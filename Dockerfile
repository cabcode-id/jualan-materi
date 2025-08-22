# --- Stage 1: composer (build deps) ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --no-scripts
COPY . .
RUN composer dump-autoload --optimize

# --- Stage 2: node (build assets, jika pakai Vite) ---
FROM node:18-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json* pnpm-lock.yaml* yarn.lock* ./
RUN if [ -f pnpm-lock.yaml ]; then npm i -g pnpm && pnpm i --frozen-lockfile; \
    elif [ -f yarn.lock ]; then yarn --frozen-lockfile; \
    elif [ -f package-lock.json ]; then npm ci; else npm i; fi
COPY . .
RUN if [ -f package.json ]; then \
      if npm run | grep -q " build"; then npm run build; fi; \
    fi

# --- Stage 3: runtime (Apache + PHP) ---
FROM php:8.2-apache

# deps untuk ekstensi gd + zip, dll
RUN apt-get update -y && apt-get install -y --no-install-recommends \
      libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev libxml2-dev \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd --with-jpeg --with-freetype \
  && docker-php-ext-install gd pdo_mysql mbstring zip \
  && a2enmod rewrite headers

# DocumentRoot ke /var/www/public
ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
 && sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# PHP uploads config
RUN printf "%s\n" \
  "file_uploads=On" "memory_limit=1024M" "upload_max_filesize=512M" \
  "post_max_size=512M" "max_execution_time=1200" \
  > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www

# copy app + vendor dari stage composer
COPY --from=vendor /app /var/www
# copy hasil build frontend (jika ada)
COPY --from=frontend /app/public/build /var/www/public/build

# permission laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
 && php artisan storage:link || true

EXPOSE 80
CMD ["apache2-foreground"]
