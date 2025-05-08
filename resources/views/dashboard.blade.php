@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <h1 class="text-3xl font-semibold mb-6">{{ __('Selamat Datang di Dashboard!') }}</h1>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-700 shadow-md rounded-lg p-6">
              <h2 class="text-xl font-semibold mb-2">{{ __('Daftar Hadir Aktif') }}</h2>
              <p class="text-gray-600 dark:text-gray-300">{{ __('Kelola daftar hadir yang sedang aktif.') }}</p>
              <a href="{{ route('admin.attendance-lists.index') }}"
                class="inline-flex items-center mt-4 px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-900 dark:active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Lihat Daftar Hadir') }}
              </a>
            </div>

            <div class="bg-white dark:bg-slate-700 shadow-md rounded-lg p-6">
              <h2 class="text-xl font-semibold mb-2">{{ __('Buat Daftar Hadir Baru') }}</h2>
              <p class="text-gray-600 dark:text-gray-300">{{ __('Buat daftar hadir untuk acara atau kegiatan baru.') }}
              </p>
              <a href="{{ route('admin.attendance-lists.create') }}"
                class="inline-flex items-center mt-4 px-4 py-2 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-600 focus:bg-green-700 dark:focus:bg-green-600 active:bg-green-900 dark:active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Buat Baru') }}
              </a>
            </div>

            <div class="bg-white dark:bg-slate-700 shadow-md rounded-lg p-6">
              <h2 class="text-xl font-semibold mb-2">{{ __('Profil Anda') }}</h2>
              <p class="text-gray-600 dark:text-gray-300">{{ __('Kelola informasi profil pribadi Anda.') }}</p>
              <a href="{{ route('profile.edit') }}"
                class="inline-flex items-center mt-4 px-4 py-2 bg-gray-500 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-600 dark:hover:bg-gray-700 focus:bg-gray-600 dark:focus:bg-gray-700 active:bg-gray-700 dark:active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Edit Profil') }}
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
