<div>
    <div class="flex flex-col space-y-4 py-4" wire:loading.class="opacity-50" wire:target="saveInfo">
        <form wire:submit.prevent="saveInfo">
            <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <x-input.group label="Full name *" for="name" :error="$errors->first('name')">
                        <x-input id="name" type="text" placeholder="Enter full name" wire:model="name" required></x-input>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Phone" for="phone" :error="$errors->first('phone')">
                        <x-input id="phone" type="tel" placeholder="Enter mobile number" wire:model="phone"></x-input>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Email *" for="phone" :error="$errors->first('email')">
                        <x-input id="email" type="email" placeholder="Enter email address" wire:model="email"></x-input>
                    </x-input.group>
                </div>
            </div>
            <div class="flex md:justify-end items-center">
                <x-button.dark>Save</x-button.dark>
            </div>
        </form>
    </div>
    <div class="flex flex-col space-y-4 py-4 border-t border-gray-300">
        <p>Update account password</p>
        <form wire:submit.prevent="updatePasswordConfirm">
            <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                <x-input.group label="New password" for="newPassword" :error="$errors->first('newPassword')">
                    <x-input type="password" id="newPassword" placeholder="Enter new password" wire:model="newPassword"></x-input>
                </x-input.group>
            </div>
            <div class="flex md:justify-end items-center">
                <x-button.dark>Update password</x-button.dark>
            </div>
        </form>
    </div>

    <!-- Confirm password change modal -->
    <x-modal wire:model="showConfirmPasswordChange" id="deleteLocation" max-width="md">
        <div class="p-4 flex justify-between items-center">
            <x-title title="Confirm password change" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="$set('showConfirmPasswordChange', false)"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            <form wire:submit.prevent="updatePassword">
                <x-input.group label="Current password" for="currentPassword" :error="$errors->first('currentPassword')">
                    <x-input type="password" id="currentPassword" placeholder="Enter new password" wire:model="currentPassword"></x-input>
                </x-input.group>
                <input type="submit" hidden>
            </form>
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex md:justify-end items-center space-x-2">
                <x-button.default wire:click="$set('showConfirmPasswordChange', false)">Nevermind</x-button.default>
                <x-button.dark wire:click="updatePassword">Update password</x-button.dark>
            </div>
        </div>
    </x-modal>
</div>
