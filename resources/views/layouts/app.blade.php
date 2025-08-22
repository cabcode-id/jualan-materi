<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- FOR NGROK LOCAL ONLY --}}
       {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--}}

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}" />

        @vite([
            'resources/css/styles.css',
            'resources/js/app.js',
            'resources/js/scripts.js',
       ])
        <!-- <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <script src="{{ asset('js/scripts.js') }}"></script> -->
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script> --}}
        <link rel="stylesheet" href="{{asset('packages/select2/dist/css/select2.css')}}">
        @livewireStyles
    </head>
    <body class="font-sans antialiased nav-fixed">
        <div class="min-h-screen bg-gray-100">

            <livewire:layout.navigation />

            <livewire:layout.sidebar />
            <div id="layoutSidenav_content">

            <main>
                {{ $slot }}
            </main>
            <livewire:layout.footer />
            <livewire:show-alert />
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Check for flash message
                    @if (session()->has('alert'))
                        Swal.fire({
                            icon: '{{ session('alert.type') }}',
                            title: '{{ session('alert.title') }}',
                            text: '{{ session('alert.message') }}',
                        });
                    @endif
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Check for flash message
                    @if (session()->has('success'))
                        Swal.fire({
                            icon: '{{ session('alert.type') }}',
                            title: '{{ session('alert.title') }}',
                            text: '{{ session('alert.message') }}',
                        });
                    @endif
                });
            </script>
            <script src="{{ asset('js/check-session.js') }}"></script>
        </div>
        </div>
        @livewireScripts
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('packages/select2/dist/js/select2.full.js')}}"></script>

</html>
