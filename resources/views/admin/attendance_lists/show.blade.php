@extends('layouts.main')

@section('title', 'Detail Daftar Hadir: ' . $attendanceList->event_name)

@section('content')
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- Header Halaman --}}
      <header class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
          Detail: {{ $attendanceList->event_name }}
        </h1>
      </header>

      @if (session('success'))
        <div
          class="mb-4 bg-green-100 border border-green-400 text-green-700 dark:bg-green-700 dark:text-green-100 dark:border-green-600 px-4 py-3 rounded relative"
          role="alert">
          <strong class="font-bold">Sukses!</strong>
          <span class="block sm:inline">{{ session('success') }}</span>
        </div>
      @endif

      <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
          <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">Informasi Kegiatan</h3>
          <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Nama Kegiatan:</dt>
              <dd class="text-gray-900 dark:text-gray-100">{{ $attendanceList->event_name }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Deskripsi:</dt>
              <dd class="text-gray-900 dark:text-gray-100">{{ $attendanceList->description ?? '-' }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Tanggal:</dt>
              <dd class="text-gray-900 dark:text-gray-100">{{ $attendanceList->event_date->format('d F Y') }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Jam Mulai Kegiatan:</dt>
              <dd class="text-gray-900 dark:text-gray-100">
                {{ \Carbon\Carbon::parse($attendanceList->event_start_time)->format('H:i') }}</dd>
            </div>
          </dl>

          <h3 class="text-xl font-semibold mt-6 mb-3 text-gray-900 dark:text-gray-100">Pengaturan Waktu Check-in</h3>
          <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Buka Check-in:</dt>
              <dd class="text-gray-900 dark:text-gray-100">
                {{ \Carbon\Carbon::parse($attendanceList->checkin_open_time)->format('H:i') }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Target Tepat Waktu:</dt>
              <dd class="text-gray-900 dark:text-gray-100">
                {{ \Carbon\Carbon::parse($attendanceList->target_ontime_time)->format('H:i') }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Tutup Check-in:</dt>
              <dd class="text-gray-900 dark:text-gray-100">
                {{ \Carbon\Carbon::parse($attendanceList->checkin_close_time)->format('H:i') }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Status Daftar Hadir:</dt>
              <dd class="text-gray-900 dark:text-gray-100">{{ ucfirst($attendanceList->status) }}</dd>
            </div>
          </dl>

          <h3 class="text-xl font-semibold mt-6 mb-3 text-gray-900 dark:text-gray-100">Aturan Emoticon</h3>
          @if ($attendanceList->emoticonRules->isNotEmpty())
            <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
              @foreach ($attendanceList->emoticonRules as $rule)
                <li>
                  <strong>{{ $rule->status_name }}</strong>
                  (Offset: {{ $rule->time_window_start_offset_minutes }}m s/d
                  {{ $rule->time_window_end_offset_minutes }}m)
                  :
                  Emoticons: <span class="font-mono">
                    @php
                      $emoticonsArray = is_string($rule->emoticons)
                          ? json_decode($rule->emoticons, true)
                          : $rule->emoticons;
                    @endphp
                    {{ is_array($emoticonsArray) ? implode(', ', $emoticonsArray) : '' }}
                  </span>
                </li>
              @endforeach
            </ul>
          @else
            <p class="text-gray-600 dark:text-gray-400">Belum ada aturan emoticon yang ditetapkan.</p>
          @endif

          <div class="mt-8">
            <a href="{{ route('admin.attendance-lists.edit', $attendanceList->id) }}"
              class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
              Edit Daftar Hadir
            </a>
          </div>
        </div>
      </div>

      @if ($attendanceList->unique_link_token)
        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
          <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-gray-100">Link & QR Code Check-in</h3>
            <p class="mb-2">
              <strong class="text-gray-600 dark:text-gray-400">Link:</strong>
              <a href="{{ $checkinUrl }}" target="_blank"
                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 break-all">{{ $checkinUrl }}</a>
            </p>
            <div class="mt-6 bg-white dark:bg-slate-700 rounded-lg shadow p-6 flex flex-col items-center">
              <div class="flex flex-col items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 flex">
                  {{ __('Link Presensi & QR Code') }}</h3>
                <div class="my-2 p-4 inline-block bg-white dark:bg-slate-800 rounded-lg shadow-inner">
                  {!! $qrCode !!}
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                  {{ __('Pindai QR Code ini atau gunakan link di bawah untuk presensi.') }}</p>
                <div class="mt-2">
                  <a href="{{ $checkinUrl }}" target="_blank"
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 break-all">{{ $checkinUrl }}</a>
                </div>
              </div>
              <div class="mt-6 self-center">
                <form action="{{ route('admin.attendance-lists.regenerate-link', $attendanceList->id) }}" method="POST"
                  class="inline">
                  @csrf
                  @method('PATCH')
                  <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 dark:bg-orange-600 dark:hover:bg-orange-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150"
                    onclick="return confirm('{{ __('Apakah Anda yakin ingin memperbarui link dan QR Code? Link dan QR Code lama akan menjadi tidak valid.') }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-5 h-5 mr-2">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.023 9.348h4.992v-.001M17.036 12.286h1.97M18.049 15.123h1.004M5.678 18.697a2.43 2.43 0 001.782.369m0 0a2.415 2.415 0 001.764-.376m0 0a2.415 2.415 0 00-3.546 0m1.023-11.983c.031-.051.062-.102.094-.153m0 0a2.493 2.493 0 014.112 0m0 0c-.031.051-.062.102-.094.153m-4.112 0a2.493 2.493 0 014.112 0m0 0c-.031-.051-.062-.102-.094-.153M12 20.196c-5.466 0-9.91-4.54-9.91-10.13A9.875 9.875 0 0112 4c5.465 0 9.91 4.54 9.91 10.13a9.875 9.875 0 01-9.91 6.196m0 0c1.598.03 3.172.076 4.769.139m-4.769-.139v-.003z" />
                    </svg>
                    {{ __('Perbaharui Link') }}
                  </button>
                </form>
                @if (session('link_regenerated'))
                  <div class="mt-2 text-sm text-green-600 dark:text-green-400">
                    {{ session('link_regenerated') }}
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endif

      <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
          <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Peserta yang Sudah Check-in (Total:
            {{ $checkins->total() }})</h3>

          @if ($checkins->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">Belum ada peserta yang melakukan check-in untuk kegiatan ini.</p>
          @else
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                  <tr>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      No.</th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Nama Peserta</th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Tim/Instansi</th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Waktu Check-in</th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Status</th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Emoticon</th>
                    <th scope="col"
                      class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                      Selfie</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                  @foreach ($checkins as $index => $checkin)
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $checkins->firstItem() + $index }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $checkin->participant_name }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $checkin->team_name ?? '-' }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $checkin->checkin_time->format('d M Y, H:i:s') }}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span
                          class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if (Str::contains(strtolower($checkin->status_at_checkin), 'tepat waktu')) bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100
                                            @elseif(Str::contains(strtolower($checkin->status_at_checkin), 'awal')) bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100
                                            @elseif(Str::contains(strtolower($checkin->status_at_checkin), 'terlambat')) bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100
                                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-100 @endif">
                          {{ $checkin->status_at_checkin }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-2xl text-center">{{ $checkin->displayed_emoticon }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        @if ($checkin->selfie_image_path)
                          {{-- Tombol untuk membuka modal (membutuhkan Alpine.js) --}}
                          <button type="button"
                            @click="openModal('{{ asset('storage/' . $checkin->selfie_image_path) }}')">
                            <img src="{{ asset('storage/' . $checkin->selfie_image_path) }}"
                              alt="Selfie {{ $checkin->participant_name }}"
                              class="h-12 w-12 object-cover rounded hover:opacity-75 transition-opacity">
                          </button>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="mt-4">
              {{ $checkins->links() }} {{-- Paginasi bawaan Laravel mungkin perlu styling tambahan agar cocok dengan dark mode --}}
            </div>
          @endif
        </div>
      </div>

      <div class="mt-8">
        <a href="{{ route('admin.attendance-lists.index') }}"
          class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
          &larr; Kembali ke Daftar Hadir
        </a>
      </div>
    </div>
  </div>

  {{-- Modal untuk Image Preview (membutuhkan Alpine.js) --}}
  {{-- Pastikan Alpine.js dimuat di layout utama Anda (layouts.main.blade.php) --}}
  {{-- Contoh: <script src="//unpkg.com/alpinejs" defer></script> --}}
  <div x-data="imageModal()" @keydown.escape.window="closeModal()" x-show="showModal"
    class="fixed inset-0 z-[99] overflow-y-auto" style="display: none;" x-cloak>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
      <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 transition-opacity" @click="closeModal()">
        <div class="absolute inset-0 bg-gray-700 dark:bg-slate-900 opacity-75"></div>
      </div>

      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <div x-show="showModal" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full"
        role="dialog" aria-modal="true" aria-labelledby="modal-headline">
        <div class="p-4 sm:p-6">
          <img :src="imageUrl" alt="Selfie Detail" class="w-full h-auto object-contain max-h-[80vh] rounded">
        </div>
        <div class="bg-gray-50 dark:bg-slate-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button @click="closeModal()" type="button"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-slate-600 shadow-sm px-4 py-2 bg-white dark:bg-slate-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-800 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  {{-- Script untuk Alpine.js Modal --}}
  <script>
    function imageModal() {
      return {
        showModal: false,
        imageUrl: '',
        openModal(url) {
          this.imageUrl = url;
          this.showModal = true;
          // Mencegah scroll pada body ketika modal terbuka
          document.body.classList.add('overflow-hidden');
        },
        closeModal() {
          this.showModal = false;
          this.imageUrl = '';
          // Mengembalikan scroll pada body
          document.body.classList.remove('overflow-hidden');
        }
      }
    }
  </script>
  {{-- Jika belum ada Alpine.js di layouts.main.blade.php, Anda bisa menambahkannya di sini atau di layout utama --}}
  {{-- Contoh: <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}
  {{-- Atau jika menggunakan Alpine v3 (lebih direkomendasikan): --}}
  {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
@endpush
