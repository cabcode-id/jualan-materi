<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- FOR NGROK LOCAL ONLY --}}
{{--        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--}}

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}" />

        <!-- <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <script src="{{ asset('js/scripts.js') }}"></script> -->
        @vite([
            'resources/css/styles.css',
            'resources/js/app.js',
            'resources/js/scripts.js',
       ])
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            window.recaptchaCallback = function(token) {
                Livewire.dispatch('recaptcha-response', { response: token });
            }
        </script>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body class="bg-primary">
     {{ $slot }}
    </body>
</html>
