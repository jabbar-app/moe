@extends('layouts.main')

@section('title', 'Edit Daftar Hadir')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
        {{ __('Edit Daftar Hadir') }}
      </h2>
      <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
          <form method="POST" action="{{ route('admin.attendance-lists.update', $attendanceList) }}">
            @csrf
            @method('PUT')

            @if ($errors->any())
              <div class="mb-4">
                <div class="font-medium text-red-600">
                  {{ __('Ada beberapa kesalahan dalam input Anda.') }}
                </div>

                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            @include('admin.attendance_lists.attendance-form', ['attendanceList' => $attendanceList])

            <h3 class="text-lg font-medium text-gray-900 dark:text-white mt-6 mb-2">Pengaturan Emoticon per Status Waktu
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Offset waktu dihitung relatif terhadap "Jam Target
              Tepat Waktu". Emoticon dipisahkan koma (misal: 😊,🎉).</p>

            <div id="emoticon-rules-container">
              @foreach (old('rules', $attendanceList->emoticonRules->toArray()) as $index => $rule)
                <div class="emoticon-rule p-4 border rounded-md mb-4">
                  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                      <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                        for="rules_{{ $index }}_status_name">Nama Status</label>
                      <input id="rules_{{ $index }}_status_name"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="text" name="rules[{{ $index }}][status_name]"
                        value="{{ old('rules.' . $index . '.status_name', $rule['status_name'] ?? '') }}" required />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                        for="rules_{{ $index }}_start_offset">Offset Mulai (menit)</label>
                      <input id="rules_{{ $index }}_start_offset"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="number" name="rules[{{ $index }}][start_offset]"
                        value="{{ old('rules.' . $index . '.start_offset', $rule['time_window_start_offset_minutes'] ?? '') }}"
                        placeholder="-60" required />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                        for="rules_{{ $index }}_end_offset">Offset Akhir (menit)</label>
                      <input id="rules_{{ $index }}_end_offset"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="number" name="rules[{{ $index }}][end_offset]"
                        value="{{ old('rules.' . $index . '.end_offset', $rule['time_window_end_offset_minutes'] ?? '') }}"
                        placeholder="-30" required />
                    </div>
                    <div>
                      <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"
                        for="rules_{{ $index }}_emoticons">Emoticons (koma ,)</label>
                      <input id="rules_{{ $index }}_emoticons"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="text" name="rules[{{ $index }}][emoticons]"
                        value="{{ old('rules.' . $index . '.emoticons', is_array($rule['emoticons'] ?? []) ? implode(',', $rule['emoticons'] ?? []) : $rule['emoticons'] ?? '') }}"
                        placeholder="😀,😎" required />
                      <input type="hidden" name="rules[{{ $index }}][id]" value="{{ $rule['id'] ?? '' }}">
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
                {{ __('Simpan Perubahan') }}
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
      let ruleIndex = {{ count(old('rules', $attendanceList->emoticonRules->toArray())) }};

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
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="rules_${ruleIndex}_status_name">Nama Status</label>
                            <input id="rules_${ruleIndex}_status_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="rules[${ruleIndex}][status_name]" required />
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="rules_${ruleIndex}_start_offset">Offset Mulai (menit)</label>
                            <input id="rules_${ruleIndex}_start_offset" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="rules[${ruleIndex}][start_offset]" placeholder="-60" required />
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="rules_${ruleIndex}_end_offset">Offset Akhir (menit)</label>
                            <input id="rules_${ruleIndex}_end_offset" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="rules[${ruleIndex}][end_offset]" placeholder="-30" required />
                        </div>
                        <div class="flex items-end">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="rules_${ruleIndex}_emoticons">Emoticons (koma ,)</label>
                            <input id="rules_${ruleIndex}_emoticons" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="rules[${ruleIndex}][emoticons]" placeholder="😀,😎" required />
                            <button type="button" class="remove-rule px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 ml-2">Hapus</button>
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
