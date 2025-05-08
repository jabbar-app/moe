@extends('layouts.main')

@section('title', 'Buat Daftar Hadir Baru')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
        {{ __('Buat Daftar Hadir Baru') }}
      </h2>
      <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
          <form method="POST" action="{{ route('admin.attendance-lists.store') }}">
            @csrf

            <div>
              <x-input-label for="event_name" :value="__('Nama Kegiatan')" />
              <x-text-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" :value="old('event_name')"
                required autofocus />
              <x-input-error :messages="$errors->get('event_name')" class="mt-2" />
            </div>

            <div class="mt-4">
              <x-input-label for="description" :value="__('Deskripsi (Opsional)')" />
              <textarea id="description" name="description" rows="3"
                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
              <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
              <div>
                <x-input-label for="event_date" :value="__('Tanggal Kegiatan')" />
                <x-text-input id="event_date" class="block mt-1 w-full" type="date" name="event_date" :value="old('event_date')"
                  required />
                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="event_start_time" :value="__('Jam Mulai Kegiatan')" />
                <x-text-input id="event_start_time" class="block mt-1 w-full" type="time" name="event_start_time"
                  :value="old('event_start_time')" required />
                <x-input-error :messages="$errors->get('event_start_time')" class="mt-2" />
              </div>
            </div>

            <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-6 mb-2">Pengaturan Waktu Check-in</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div>
                <x-input-label for="checkin_open_time" :value="__('Jam Buka Check-in')" />
                <x-text-input id="checkin_open_time" class="block mt-1 w-full" type="time" name="checkin_open_time"
                  :value="old('checkin_open_time')" required />
                <x-input-error :messages="$errors->get('checkin_open_time')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="target_ontime_time" :value="__('Jam Target Tepat Waktu')" />
                <x-text-input id="target_ontime_time" class="block mt-1 w-full" type="time" name="target_ontime_time"
                  :value="old('target_ontime_time')" required />
                <x-input-error :messages="$errors->get('target_ontime_time')" class="mt-2" />
              </div>
              <div>
                <x-input-label for="checkin_close_time" :value="__('Jam Tutup Check-in')" />
                <x-text-input id="checkin_close_time" class="block mt-1 w-full" type="time" name="checkin_close_time"
                  :value="old('checkin_close_time')" required />
                <x-input-error :messages="$errors->get('checkin_close_time')" class="mt-2" />
              </div>
            </div>

            <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-6 mb-2">Pengaturan Emoticon per Status Waktu
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Offset waktu dihitung relatif terhadap "Jam Target
              Tepat Waktu". Emoticon dipisahkan koma (misal: 😊,🎉).</p>

            <div id="emoticon-rules-container">
              @foreach (old('rules', $defaultRules) as $index => $rule)
                <div class="emoticon-rule p-4 border rounded-md mb-4">
                  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                      <x-input-label :for="'rules_' . $index . '_status_name'" :value="__('Nama Status')" />
                      <x-text-input :id="'rules_' . $index . '_status_name'" class="block mt-1 w-full" type="text" :name="'rules[' . $index . '][status_name]'"
                        :value="$rule['status_name'] ?? ''" required />
                    </div>
                    <div>
                      <x-input-label :for="'rules_' . $index . '_start_offset'" :value="__('Offset Mulai (menit)')" />
                      <x-text-input :id="'rules_' . $index . '_start_offset'" class="block mt-1 w-full" type="number" :name="'rules[' . $index . '][start_offset]'"
                        :value="$rule['start_offset'] ?? ''" placeholder="-60" required />
                    </div>
                    <div>
                      <x-input-label :for="'rules_' . $index . '_end_offset'" :value="__('Offset Akhir (menit)')" />
                      <x-text-input :id="'rules_' . $index . '_end_offset'" class="block mt-1 w-full" type="number" :name="'rules[' . $index . '][end_offset]'"
                        :value="$rule['end_offset'] ?? ''" placeholder="-30" required />
                    </div>
                    <div>
                      <x-input-label :for="'rules_' . $index . '_emoticons'" :value="__('Emoticons (koma ,)')" />
                      <x-text-input :id="'rules_' . $index . '_emoticons'" class="block mt-1 w-full" type="text" :name="'rules[' . $index . '][emoticons]'"
                        :value="$rule['emoticons'] ?? ''" placeholder="😀,😎" required />
                    </div>
                  </div>
                  @if ($index > 0)
                    <button type="button" class="text-red-500 hover:text-red-700 mt-2 remove-rule">Hapus Aturan
                      Ini</button>
                  @endif
                </div>
              @endforeach
            </div>
            <button type="button" id="add-emoticon-rule"
              class="mt-2 mb-6 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
              Tambah Aturan Emoticon
            </button>

            <div class="flex items-center justify-end mt-4">
              <a href="{{ route('admin.attendance-lists.index') }}"
                class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                Batal
              </a>
              <x-primary-button>
                {{ __('Simpan Daftar Hadir') }}
              </x-primary-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const container = document.getElementById('emoticon-rules-container');
      const addButton = document.getElementById('add-emoticon-rule');
      let ruleIndex = {{ count(old('rules', $defaultRules)) }};

      function handleRemoveRule(event) {
        event.preventDefault();
        const rule = event.target.closest('.emoticon-rule');
        if (rule) rule.remove();
      }

      function addRemoveEventListeners() {
        document.querySelectorAll('.remove-rule').forEach(button => {
          button.removeEventListener('click', handleRemoveRule);
          button.addEventListener('click', handleRemoveRule);
        });
      }

      addButton.addEventListener('click', function() {
        const newRuleDiv = document.createElement('div');
        newRuleDiv.classList.add('emoticon-rule', 'p-4', 'border', 'rounded-md', 'mb-4');
        newRuleDiv.innerHTML = `
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
              <label class="block font-medium text-sm text-gray-700" for="rules_${ruleIndex}_status_name">Nama Status</label>
              <input id="rules_${ruleIndex}_status_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="rules[${ruleIndex}][status_name]" required />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700" for="rules_${ruleIndex}_start_offset">Offset Mulai (menit)</label>
              <input id="rules_${ruleIndex}_start_offset" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="rules[${ruleIndex}][start_offset]" placeholder="-60" required />
            </div>
            <div>
              <label class="block font-medium text-sm text-gray-700" for="rules_${ruleIndex}_end_offset">Offset Akhir (menit)</label>
              <input id="rules_${ruleIndex}_end_offset" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="rules[${ruleIndex}][end_offset]" placeholder="-30" required />
            </div>
            <div class="flex items-end">
              <button type="button" class="remove-rule px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Hapus</button>
            </div>
          </div>
        `;
        container.appendChild(newRuleDiv);
        ruleIndex++;
        addRemoveEventListeners();
      });

      addRemoveEventListeners();
    });
  </script>
@endpush
