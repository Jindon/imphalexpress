<div>
    <div class="w-full mx-auto mt-6 md:w-2/3 md:mt-10">
        <div>
            <x-title title="Pricing settings" subtitle="Delivery pricing based on locations" title-size="lg"></x-title>
            <div class="flex flex-col py-4 space-y-4" wire:loading.class="opacity-50" wire:target="save">
                <form wire:submit.prevent="save">
                    <div class="grid gap-2 grids-cols-1 md:grid-cols-3">
                        <x-input.group type="text" label="From *" for="from" :error="$errors->first('from_id')">
                            <x-input.select wire:model="from_id" id="from">
                                <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="">Select Location</option>
                                @foreach($locations as $location)
                                    <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>

                        <x-input.group type="text" label="To *" for="to" :error="$errors->first('to_id')">
                            <x-input.select wire:model="to_id" id="to">
                                <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="">Select location</option>
                                @foreach($locations as $location)
                                    <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>

                        <div class="flex items-start space-x-2">
                            <x-input.group type="text" label="Price *" for="price" :error="$errors->first('price')">
                                <x-input.text wire:model="price" id="price" placeholder="Enter delivery price" required></x-input.text>
                            </x-input.group>

                            <div class="flex items-center mt-6 md:justify-end">
                                <x-button.dark>Save</x-button.dark>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="mt-1">
                    <small class="text-gray-500">Add new or update exisiting. If no entries exists, a new pricing will be created, else existing pricing will be updated.</small>
                </div>
            </div>
        </div>

        <div class="py-4 border-t">
            <h3 class="mb-4 text-lg font-bold text-gray-700">Pricing</h3>

            <div class="grid gap-2 grids-cols-1 md:grid-cols-3" wire:loading.class="opacity-50">
                @if(count($deliveryPricing) > 0)
                    @foreach($deliveryPricing as $pricing)
                        <div class="flex items-center justify-between bg-orange-100 border rounded" wire:key="pricing-{{ $pricing->id }}">
                            <div class="flex items-center justify-between flex-1 p-2">
                                <div class="leading-none text-orange-900">
                                    <p class="mb-1 font-bold">{{ $pricing->from->name }}</p>
                                    <p class="font-bold">{{ $pricing->to->name }}</p>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold leading-none text-orange-600">₹{{ $pricing->charge }}</p>
                                </div>
                            </div>
                            <div class="p-2 border-l">
                                <x-button.icon.close
                                    icon-width="3"
                                    class="p-2"
                                    wire:click="confirmDelete({{ $pricing->id }})"
                                >
                                </x-button.icon.close>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-1 p-4 bg-gray-100 md:col-span-3">
                        <p class="text-center text-gray-500">No pricing set yet...</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete confirmation modal -->
    <x-modal wire:model="deleteConfirmation" id="deletePricing" max-width="md">
        <div class="flex items-center justify-between p-4">
            <x-title title="Delete pricing" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="cancelDelete"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            Are you sure you want to delete this pricing. This action is irreversible!
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex items-center space-x-2 md:justify-end">
                <x-button.default wire:click="cancelDelete">Nevermind</x-button.default>
                <x-button.danger wire:click="delete">Delete</x-button.danger>
            </div>
        </div>
    </x-modal>
</div>

