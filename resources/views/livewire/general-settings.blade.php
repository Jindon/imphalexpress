<div>
    <div class="flex flex-col space-y-4 py-4">
        <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
            <div wire:loading.class="opacity-50">
                <label class="text-sm text-gray-600">Site name</label>
                <x-input placeholder="Enter site name" wire:model="siteName"></x-input>
            </div>
            <div wire:loading.class="opacity-50">
                <label class="text-sm text-gray-600">Contact number</label>
                <x-input placeholder="Enter contact number" wire:model="contactNumber"></x-input>
            </div>
            <div wire:loading.class="opacity-50">
                <label class="text-sm text-gray-600">Receive callback email on</label>
                <x-input placeholder="Enter email to receive callback request on" wire:model="callbackEmail"></x-input>
            </div>
        </div>
        <div class="flex md:justify-end items-center" wire:loading.class="opacity-50">
            <x-button type="dark" text="Save" class="py-3 px-4 text-sm" wire:click="save"/>
        </div>
    </div>

{{--    @push('scripts')--}}
{{--    <script>--}}
{{--        Livewire.on('alert', event => {--}}
{{--            // alert('Settings saved successfully');--}}
{{--            Toastify({--}}
{{--                text: "This is a toast",--}}
{{--                duration: 30000,--}}
{{--                position: 'center',--}}
{{--                className: "bg-green-600 text-green-100",--}}
{{--            }).showToast();--}}
{{--        })--}}
{{--    </script>--}}
{{--    @endpush--}}
</div>
