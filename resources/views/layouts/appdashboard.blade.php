<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>@yield('title', 'Dashboard')</title>

    @vite(['resources/css/style.css', 'resources/js/index.js'])
    @stack('styles')
    <link rel="stylesheet"
        href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</head>

<body
    x-data="{ page: 'ecommerce', loaded: true, darkMode: false, sidebarToggle: false }"
    x-init="
        darkMode = JSON.parse(localStorage.getItem('darkMode')) ?? false;
        $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))
    "
    :class="{'dark bg-gray-900': darkMode === true}">

    {{-- Preloader --}}
    @include('layouts.preloader')

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">

            <main id="main-content">

                {{-- Header --}}
                @include('layouts.header')

                {{-- Main Content --}}
                <div class="mx-auto max-w-(--breakpoint-2xl) p-4">
                    @yield('content')
                </div>

            </main>
        </div>
    </div>

</body>

</html>