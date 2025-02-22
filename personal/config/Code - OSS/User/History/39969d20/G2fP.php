<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}

    <!-- Carga de fuentes de manera eficiente -->
    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'" type="text/css" crossorigin="anonymous">

    @stack('css')

    <!-- Scripts con defer para no bloquear el renderizado -->
    <script src="https://kit.fontawesome.com/adb5877593.js" defer crossorigin="anonymous"></script>

    <!-- Usa Vite para CSS y JS (pero los moveremos al final del body si es posible) -->
    @livewireStyles
    @stack('head')

    <!-- Optimizamos el CSS y JS usando media="none" y onload para que no bloqueen el renderizado -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" media="none" onload="this.media='all'">
</head>

<body class="font-sans antialiased dark:bg-gray-900">
    <x-banner />
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('navigation')
        <main>{{ $slot }}</main>
        <div class="mt-16">
            @include('layouts.partials.app.footer')
        </div>
    </div>

    @stack('modals')

    <!-- Scripts no críticos con defer -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    @livewireScripts
    @stack('js')

    @if (session('swal'))
        <script>
            Swal.fire({!! json_encode(session('swal')) !!});
        </script>
    @endif

    <script>
        Livewire.on('swal', data => {
            Swal.fire(data[0]);
        });
    </script>

    <!-- Scripts generados por Vite (mover al final si es posible) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</body>

</html>
