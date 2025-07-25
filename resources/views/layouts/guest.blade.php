<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen bg-white">
            
            {{-- ====================================================== --}}
            {{--    PERBAIKAN HANYA PADA CLASS DI DIV DI BAWAH INI      --}}
            {{-- ====================================================== --}}
            <div class="hidden lg:flex w-1/2 flex-col justify-center p-12 bg-gray-50 relative">
                
                <!-- Logo Aplikasi Anda (Sekarang diposisikan absolut terhadap parent) -->
                <a href="/" class="absolute top-12 left-12">
                    <img src="{{ asset('assets/img/logo_app.png') }}" alt="Logo Aplikasi" class="h-40">
                </a>

                <!-- Konten Utama Kiri (Otomatis di tengah karena parent-nya justify-center) -->
                <div class="w-full">
                    <h1 class="text-4xl font-bold text-gray-800 leading-tight">
                        Platform Simulasi &<br>Manajemen Energi Terbarukan
                    </h1>
                    <p class="mt-4 text-gray-500">
                        Wujudkan efisiensi energi untuk masa depan yang lebih cerah.
                    </p>
                </div>
                
            </div>

            <!-- Kolom Kanan: Form Login (Tidak ada perubahan) -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>