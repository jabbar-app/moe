@extends('layouts.blank')

@section('title', 'Presensi Tidak Valid')

@section('content')
  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="bg-white dark:bg-slate-800 p-8 rounded-lg shadow-md max-w-xl w-full text-center">
      <div class="mb-6">
        <div class="text-6xl mb-2">🚫</div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Presensi Tidak Bisa Diakses</h1>
        <p class="text-gray-600 dark:text-gray-300">
          {{ $message ?? 'Link presensi ini tidak tersedia atau sudah tidak aktif.' }}
        </p>
      </div>
      <a href="{{ url('/') }}"
        class="inline-block mt-4 px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
        Kembali ke Beranda
      </a>
    </div>
  </div>
@endsection
