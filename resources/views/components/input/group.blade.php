@props([
'label',
'for',
'error' => false,
])

<div {{ $attributes }}>

    <label for="{{ $for }}" class="block text-sm font-medium leading-5 text-gray-900"> {{ $label }}</label>

    {{ $slot }}

    @if ($error)
        <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
    @endif

</div>
