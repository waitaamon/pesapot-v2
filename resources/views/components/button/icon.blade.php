
<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'text-gray-900 text-sm leading-5 font-medium focus:outline-none focus:text-gray-900 focus:underline transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
    ]) }}
>
    {{ $slot }}
</button>
