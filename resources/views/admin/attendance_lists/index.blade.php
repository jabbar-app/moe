@extends('layouts.main')

@section('title', 'Daftar Hadir')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
        {{ __('Daftar Hadir') }}
      </h2>

      <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
          <div class="mb-4">
            <a href="{{ route('admin.attendance-lists.create') }}"
              class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-green-700 dark:hover:bg-green-600 focus:bg-green-700 dark:focus:bg-green-600 active:bg-green-900 dark:active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
              {{ __('Buat Daftar Hadir Baru') }}
            </a>
          </div>

          @if (session('success'))
            <div
              class="mb-4 bg-green-100 dark:bg-green-700 border-l-4 border-green-500 dark:border-green-300 text-green-700 dark:text-green-300 p-4"
              role="alert">
              <p class="font-bold">{{ __('Berhasil') }}</p>
              <p>{{ session('success') }}</p>
            </div>
          @endif

          @if ($attendanceLists->isEmpty())
            <p class="text-gray-600 dark:text-gray-300">{{ __('Belum ada daftar hadir yang dibuat.') }}</p>
          @else
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
              <thead class="bg-gray-50 dark:bg-slate-900">
                <tr>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    {{ __('Nama Kegiatan') }}</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    {{ __('Tanggal Kegiatan') }}</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    {{ __('Status') }}</th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">{{ __('Aksi') }}</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                @foreach ($attendanceLists as $attendanceList)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                      {{ $attendanceList->event_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                      {{ $attendanceList->event_date->format('d-m-Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                      @if ($attendanceList->status === 'active')
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100 rounded-full">{{ __('Aktif') }}</span>
                      @elseif ($attendanceList->status === 'pending')
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 dark:bg-yellow-700 dark:text-yellow-100 rounded-full">{{ __('Pending') }}</span>
                      @elseif ($attendanceList->status === 'finished')
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 dark:bg-blue-700 dark:text-blue-100 rounded-full">{{ __('Selesai') }}</span>
                      @elseif ($attendanceList->status === 'cancelled')
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 dark:bg-red-700 dark:text-red-100 rounded-full">{{ __('Dibatalkan') }}</span>
                      @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a href="{{ route('admin.attendance-lists.show', $attendanceList) }}"
                        class="text-indigo-600 dark:text-indigo-500 hover:text-indigo-900 dark:hover:text-indigo-300">{{ __('Lihat') }}</a>
                      <a href="{{ route('admin.attendance-lists.edit', $attendanceList) }}"
                        class="text-yellow-600 dark:text-yellow-500 hover:text-yellow-900 dark:hover:text-yellow-300 ml-2">{{ __('Edit') }}</a>
                      <form action="{{ route('admin.attendance-lists.destroy', $attendanceList) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                          class="text-red-600 dark:text-red-500 hover:text-red-900 dark:hover:text-red-300 ml-2"
                          onclick="return confirm('{{ __('Apakah Anda yakin ingin menghapus daftar hadir ini?') }}')">{{ __('Hapus') }}</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            <div class="mt-6">
              {{ $attendanceLists->links() }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
