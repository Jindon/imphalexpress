<div>
    <p class="mb-4">Locations</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
        @foreach($locations as $location)
        <div class="p-2 rounded border-2 border-gray-300 text-gray-600" wire:key="{{ 'location-' . $location->id }}">
            <div class="w-full flex items-center justify-between">
                <span>{{ $location->name }}</span>
                <div class="flex items-center space-x-1">
                    <x-button.icon.edit icon-width="3" class="p-2" wire:click="openEdit({{ $location->id }})"></x-button.icon.edit>
                    <x-button.icon.close
                        icon-width="3"
                        class="p-2"
                        wire:click="confirmDelete({{ $location->id }})"
                        :disabled="$location->can_be_deleted"
                    >
                    </x-button.icon.close>
                </div>
            </div>
        </div>
        @endforeach
        <div>
            <x-button.outline-dotted class="w-full py-4" wire:click="$toggle('showForm')">+ Add location</x-button.outline-dotted>
        </div>

        <!-- Location from modal -->
        <x-modal wire:model="showForm" id="addLocation" max-width="md">
            <div class="p-4 flex justify-between items-center">
                <x-title title="Add location" title-size="text-lg md:text-xl"></x-title>
                <div>
                    <x-button.icon.close icon-width="3" class="p-2" wire:click="$toggle('showForm')"></x-button.icon.close>
                </div>
            </div>
            <div class="p-4">
                <form wire:submit.prevent="save">
                    <div>
                        <x-input.group type="text" label="Location name *" for="name" :error="$errors->first('name')">
                            <x-input.text placeholder="Enter location name" wire:model="name" required></x-input.text>
                        </x-input.group>
                    </div>
                    <input type="submit" class="hidden">
                </form>
            </div>
            <div class="p-4 bg-gray-100">
                <div class="flex md:justify-end items-center space-x-2">
                    <x-button.default wire:click="$set('showForm', false)">Nevermind</x-button.default>
                    <x-button.dark wire:click="save">Save</x-button.dark>
                </div>
            </div>
        </x-modal>

        <!-- Delete confirmation modal -->
        <x-modal wire:model="deleteConfirmation" id="deleteLocation" max-width="md">
            <div class="p-4 flex justify-between items-center">
                <x-title title="Delete location" title-size="text-lg md:text-xl"></x-title>
                <div>
                    <x-button.icon.close icon-width="3" class="p-2" wire:click="cancelDelete"></x-button.icon.close>
                </div>
            </div>
            <div class="p-4">
                Are you sure you want to delete this location. This action is irreversible!
            </div>
            <div class="p-4 bg-gray-100">
                <div class="flex md:justify-end items-center space-x-2">
                    <x-button.default wire:click="cancelDelete">Nevermind</x-button.default>
                    <x-button.danger wire:click="delete">Delete</x-button.danger>
                </div>
            </div>
        </x-modal>
    </div>
</div>
