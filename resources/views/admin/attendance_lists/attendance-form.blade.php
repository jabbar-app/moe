<div>
  <label for="event_name"
    class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Nama Kegiatan') }}</label>
  <input id="event_name"
    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    type="text" name="event_name"
    value="{{ old('event_name', isset($attendanceList) ? $attendanceList->event_name : '') }}" required autofocus />
  @error('event_name')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<div class="mt-4">
  <label for="description"
    class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Deskripsi (Opsional)') }}</label>
  <textarea id="description" name="description" rows="3"
    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description', isset($attendanceList) ? $attendanceList->description : '') }}</textarea>
  @error('description')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
  <div>
    <label for="event_date"
      class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Tanggal Kegiatan') }}</label>
    <input id="event_date"
      class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
      type="date" name="event_date"
      value="{{ old('event_date', isset($attendanceList) ? $attendanceList->event_date->format('Y-m-d') : '') }}"
      required />
    @error('event_date')
      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
  </div>
  <div>
    <label for="event_start_time"
      class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Jam Mulai Kegiatan') }}</label>
    <input id="event_start_time"
      class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
      type="time" name="event_start_time"
      value="{{ old('event_start_time', isset($attendanceList) ? $attendanceList->event_start_time->format('H:i') : '') }}"
      required />
    @error('event_start_time')
      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
  </div>
</div>

<h3 class="text-lg font-medium text-gray-900 dark:text-white mt-6 mb-2">Pengaturan Waktu Check-in</h3>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <div>
    <label for="checkin_open_time"
      class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Jam Buka Check-in') }}</label>
    <input id="checkin_open_time"
      class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
      type="time" name="checkin_open_time"
      value="{{ old('checkin_open_time', isset($attendanceList) ? $attendanceList->checkin_open_time->format('H:i') : '') }}"
      required />
    @error('checkin_open_time')
      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
  </div>
  <div>
    <label for="target_ontime_time"
      class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Jam Target Tepat Waktu') }}</label>
    <input id="target_ontime_time"
      class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
      type="time" name="target_ontime_time"
      value="{{ old('target_ontime_time', isset($attendanceList) ? $attendanceList->target_ontime_time->format('H:i') : '') }}"
      required />
    @error('target_ontime_time')
      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
  </div>
  <div>
    <label for="checkin_close_time"
      class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Jam Tutup Check-in') }}</label>
    <input id="checkin_close_time"
      class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
      type="time" name="checkin_close_time"
      value="{{ old('checkin_close_time', isset($attendanceList) ? $attendanceList->checkin_close_time->format('H:i') : '') }}"
      required />
    @error('checkin_close_time')
      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
  </div>
</div>

<h3 class="text-lg font-medium text-gray-900 dark:text-white mt-6 mb-2">Pengaturan Status</h3>
<div>
  <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Status') }}</label>
  <select id="status"
    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    name="status">
    <option value="pending" @if (old('status', isset($attendanceList) ? $attendanceList->status : '') === 'pending') selected @endif>{{ __('Pending') }}</option>
    <option value="active" @if (old('status', isset($attendanceList) ? $attendanceList->status : '') === 'active') selected @endif>{{ __('Aktif') }}</option>
    <option value="closed" @if (old('status', isset($attendanceList) ? $attendanceList->status : '') === 'closed') selected @endif>{{ __('Ditutup') }}</option>
  </select>
  @error('status')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<h3 class="text-lg font-medium text-gray-900 dark:text-white mt-6 mb-2">Pengaturan Emoticon per Status Waktu</h3>
<p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Offset waktu dihitung relatif terhadap "Jam Target
  Tepat Waktu".
