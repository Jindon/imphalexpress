<div>
    <x-button.default class="py-3 leading-tight" wire:click="$toggle('showModal')">Import</x-button.default>

    <!-- Import businesses modal -->
    <x-modal wire:model="showModal">
        <div class="p-4 flex justify-between items-center">
            <x-title title="Import businesses" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="$set('showModal', false)"></x-button.icon.close>
            </div>
        </div>
        @unless($upload)
            <div class="p-4">
                @json($errors->first())
                <div class="flex flex-col space-y-4 justify-center items-center py-10">
                    <p class="text-gray-600 text-center">Select a CSV file to upload</p>
                    <x-input.group class="flex flex-col items-center space-y-4" :error="$errors->first('upload')">
                        <x-input.upload wire:model="upload" id="upload"
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                        >
                            Upload CSV
                        </x-input.upload>
                    </x-input.group>
                </div>
            </div>
        @else
            <form wire:submit.prevent="import">
                <div class="p-4">
                    <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <x-input.group type="text" label="Business name" for="name">
                                <x-input.select wire:model="fieldColumnMap.name" id="name">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group type="text" label="Business phone" for="name">
                                <x-input.select wire:model="fieldColumnMap.phone" id="phone">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group type="text" label="Business location ID" for="locationId">
                                <x-input.select wire:model="fieldColumnMap.location_id" id="locationId">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group type="text" label="Business Address" for="address">
                                <x-input.select wire:model="fieldColumnMap.address" id="address">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group type="text" label="Status" for="status">
                                <x-input.select wire:model="fieldColumnMap.status" id="status">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group type="text" label="Added On" for="addedOn">
                                <x-input.select wire:model="fieldColumnMap.created_at" id="addedOn">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-100">
                    <div class="flex md:justify-end items-center space-x-2">
                        <x-button.default wire:click="$set('showModal', false)">Nevermind</x-button.default>
                        <x-button.dark wire:click="import">Import businesses</x-button.dark>
                    </div>
                </div>
            </form>
        @endunless
    </x-modal>
</div>
