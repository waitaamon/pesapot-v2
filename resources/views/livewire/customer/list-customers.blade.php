<div class="p-6 sm:px-4 bg-white border-b border-gray-200">
    <div class="py-4 space-y-4">
        {{-- Top Bar --}}
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filters.search" placeholder="Search customers .."/>

            </div>
            <div class="space-x-2">
                <x-dropdown label="Bulk Actions">
                    <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                        <x-icon.download class="text-gray-400"/>
                        <span>Export Excel</span>
                    </x-dropdown.item>
                </x-dropdown>
            </div>
        </div>

        {{-- Sale Orders Table --}}
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot name="head">
                    <x-table.heading class="pr-0 w-8">
                        <x-input.checkbox wire:model="selectPage"/>
                    </x-table.heading>
                    <x-table.heading>Name</x-table.heading>
                    <x-table.heading>Status</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @if ($selectPage)
                        <x-table.row class="bg-gray-200" wire:key="row-message">
                            <x-table.cell colspan="6">
                                @unless ($selectAll)
                                    <div>
                                        <span>You've selected <strong>{{ $customers->count() }}</strong> do you want to select all <strong>{{ $customers->total() }}</strong> records?</span>
                                        <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All
                                        </x-button.link>
                                    </div>
                                @else
                                    <span>You've selected all <strong>{{ $customers->total() }}</strong> records</span>
                                @endunless

                            </x-table.cell>
                        </x-table.row>
                    @endif

                    @forelse ($customers as $customer)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $customer->id }}">

                            <x-table.cell class="pr-0">
                                <x-input.checkbox wire:model="selected" value="{{$customer->id}}"/>
                            </x-table.cell>

                            <x-table.cell>
                                {{ $customer->name }}
                            </x-table.cell>

                            <x-table.cell>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-{{ $customer->status_color }}-200 text-{{ $customer->status_color }}-800 capitalize">
                                {{ $customer->status }}
                            </span>
                            </x-table.cell>

                            <x-table.cell>
                                abc
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6">
                                <div class="flex justify-center items-center space-x-2">
                                    <x-icon.inbox class="h-8 w-8 text-gray-300"/>
                                    <span class="font-medium py-8 text-gray-400 text-xl">No customers found</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>
            <div class="grid grid-cols-8 gap-4">
                <div class="col-span-7">
                    {{ $customers->links() }}
                </div>
                <div class="col-span-1">
                    <x-input.select id="perPage" wire:model="perPage">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                    </x-input.select>
                </div>
            </div>
        </div>
    </div>
</div>
