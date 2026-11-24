<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="font-sans text-gray-900 antialiased">

    {{ $slot }}



    <!-- Alert Registrasi Berhasil -->
    @if (session('status'))
    <script>
        Swal.fire({
            title: 'Registrasi Berhasil!',
            text: 'Silahkan Login',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#16a34a'
        });
    </script>
    @endif

    @if (session('statuslogout'))
    <script>
        Swal.fire({
            title: 'Logout Berhasil!',
            text: 'Anda telah berhasil keluar. Sampai jumpa kembali!',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#16a34a'
        });
    </script>
    @endif

</body>

</html>