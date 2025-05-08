@props(['id', 'name', 'options', 'value' => null, 'label' => null])

@if ($label)
  <x-input-label for="{{ $id }}" :value="$label" />
@endif

<select id="{{ $id }}" name="{{ $name }}"
  {{ $attributes->merge(['class' => 'block mt-1 w-full rounded-md shadow-sm border-gray-300 dark:bg-slate-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}>
  @if (isset($options) && is_iterable($options))
    @foreach ($options as $optionValue => $optionLabel)
      <option value="{{ $optionValue }}" @if (old($name, $value) == $optionValue) selected @endif>{{ $optionLabel }}</option>
    @endforeach
  @endif
</select>

@error($name)
  <x-input-error :messages="$message" class="mt-2" />
@enderror
