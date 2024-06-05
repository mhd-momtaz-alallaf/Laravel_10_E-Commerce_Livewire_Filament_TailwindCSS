<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'E-Commerce' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Including the app.css and app.js --}}
        @livewireStyles {{-- Including the livewire Styles --}}
    </head>
    <body class="bg-slate-200 dark:bg-slate-700"> {{-- Adding some of tailwindcss styles --}}
        <main>
            {{ $slot }}
        </main>
        @livewireScripts {{-- Including the livewire Scripts --}}
    </body>
</html>
