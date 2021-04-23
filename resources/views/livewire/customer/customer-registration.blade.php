<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="w-full flex justify-end">
        @if(!$show)
            <x-jet-button wire:click.prevent="$set('show', true)">Add Customer</x-jet-button>
        @endif
    </div>

    @if($show)
        <div class="mt-6 text-gray-500">
            <form method="POST" wire:submit.prevent="store">
                <div>
                    <x-jet-label for="Name" value="{{ __('Customer Name') }}"/>
                    <x-jet-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus/>
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="mt-4 w-full flex justify-end">
                    <button wire:click.prevent="$set('show', false)"  type="button" class="bg-white py-2 px-4 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Cancel') }}
                    </button>
                    <button wire:click.prevent="saveAndNew"  type="button" class="ml-4 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Save And New') }}
                    </button>
                    <x-jet-button class="ml-4">
                        {{ __('Save') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    @endif
</div>

