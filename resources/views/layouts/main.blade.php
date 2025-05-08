<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Presence')</title>

  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('site.webmanifest') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800&family=Nunito+Sans:wght@300;400;600;700;800&display=swap"
    rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
  {{-- Baris di atas biasanya tidak diperlukan jika Vite sudah berjalan dengan benar --}}
  {{-- dan menyuntikkan CSS melalui tag <link> atau <style> secara otomatis. --}}
  {{-- Jika Anda mengalami masalah dengan CSS yang tidak dimuat, Anda bisa uncomment. --}}

  <style>
    [x-cloak] {
      display: none !important;
    }
  </style>

  @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-gray-200 antialiased leading-normal tracking-normal">

  <div id="app">
    @include('layouts.navigation')
    <main>
      @yield('content')
    </main>
  </div>

  {{-- Alpine.js diharapkan dimuat melalui resources/js/app.js yang di-bundle oleh Vite --}}
  {{-- Jika belum, Anda bisa menambahkannya di sini: --}}
  {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
  @stack('scripts')

</body>

</html>
