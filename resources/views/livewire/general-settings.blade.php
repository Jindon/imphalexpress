<div>
    <div class="flex flex-col space-y-4 py-4" wire:loading.class="opacity-50" wire:target="save">
        <form wire:submit.prevent="save">
            <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <x-input.group type="text" label="Site name *" for="siteName" :error="$errors->first('siteName')">
                        <x-input placeholder="Enter site name" wire:model="siteName" required></x-input>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group type="text" label="Contact number *" for="contactNumber" :error="$errors->first('contactNumber')">
                        <x-input placeholder="Enter contact number" wire:model="contactNumber" required></x-input>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Receive callback email on *" for="callbackEmail" :error="$errors->first('callbackEmail')">
                        <x-input type="email" placeholder="Enter contact number" wire:model="callbackEmail" required></x-input>
                    </x-input.group>
                </div>
            </div>
            <div class="flex md:justify-end items-center">
                <x-button.dark>Save</x-button.dark>
            </div>
        </form>
    </div>
</div>
