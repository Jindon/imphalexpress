<x-app-layout>
    <x-settings-layout>
        <div class="w-full md:w-2/3 mx-auto mt-6 md:mt-10">
            <x-title title="Account settings" title-size="lg"></x-title>
            <div class="flex flex-col space-y-4 py-4">
                <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="text-sm text-gray-600">Full name</label>
                        <x-input placeholder="Enter full name"></x-input>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Phone number</label>
                        <x-input placeholder="Enter phone number"></x-input>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <x-input placeholder="Enter email address"></x-input>
                    </div>
                </div>
                <div class="flex md:justify-end items-center">
                    <x-button type="dark" text="Save" class="py-3 px-4 text-sm" />
                </div>
            </div>
            <div class="flex flex-col space-y-4 py-4 border-t border-gray-300">
                <p>Password</p>
                <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="text-sm text-gray-600">New password</label>
                        <x-input placeholder="********" type="password"></x-input>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Current password</label>
                        <x-input placeholder="********" type="password"></x-input>
                    </div>
                </div>
                <div class="flex md:justify-end items-center">
                    <x-button type="dark" text="Update password" class="py-3 px-4 text-sm" />
                </div>
            </div>
        </div>
    </x-settings-layout>
</x-app-layout>
