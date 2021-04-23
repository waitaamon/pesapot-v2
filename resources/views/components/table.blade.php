<div class="align-middle inline-block min-w-full overflow-hidden sm:rounded-lg border-b border-gray-200">
    <table {{ $attributes->merge([
            'class' =>"min-w-full"
        ]) }} >
        <thead>
        <tr>
            {{ $head }}
        </tr>
        </thead>

        <tbody class="bg-white">
        {{ $body }}
        </tbody>
    </table>
</div>
