<x-app-layout>
    <x-settings-layout>
        <div class="w-full md:w-2/3 mx-auto mt-6 md:mt-10">
            <div>
                <x-title title="General settings" title-size="lg"></x-title>
                <livewire:general-settings />
            </div>
            <div class="flex flex-col space-y-4 py-4 border-t border-gray-300">
                <livewire:location-settings />
            </div>
        </div>
    </x-settings-layout>
</x-app-layout>
