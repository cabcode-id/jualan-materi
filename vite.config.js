import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/styles.css',
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/scripts.js'
      ],
      refresh: true,
    }),
    vue()
  ],
  resolve: {
    alias: {
      vue: 'vue/dist/vue.esm-bundler.js',
      crypto: 'node:crypto',
    },
  },
  server: {
// -    host: 'localhost',
// -    port: '3000'
    // agar bisa diakses dari host saat jalan di container
    host: true,
    port: 3000
  }
});
