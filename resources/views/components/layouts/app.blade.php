<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'E-Commerce' }}</title>
        @vite(['resources/css/app.css']) {{-- Including the app.css --}}
        @livewireStyles {{-- Including the livewire Styles --}}
    </head>
    <body class="bg-slate-200 dark:bg-slate-700"> {{-- Adding some of tailwindcss styles --}}
        @livewire('partials.navbar') {{-- Including partials.navbar component --}}

        <main>
            {{ $slot }}
        </main>

        @livewire('partials.footer') {{-- Including partials.footer component --}}

        @livewireScripts {{-- Including the livewire Scripts --}}
        @vite(['resources/js/app.js']) {{-- Including the app.js --}}

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- Including the livewire-alert-SweetAlert2 script --}}
        <x-livewire-alert::scripts /> {{-- Including the SweetAlert script --}}
    </body>
</html>
