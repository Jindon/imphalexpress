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
                    <div class="grid grids-cols-2 md:grid-cols-3 gap-2">
                        <div>
                            <x-input.group label="Tracking ID *" for="trackingId" :error="$errors->first('fieldColumnMap.tracking_id')">
                                <x-input.select wire:model="fieldColumnMap.tracking_id" id="trackingId">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Business ID *" for="businessId" :error="$errors->first('fieldColumnMap.business_id')">
                                <x-input.select wire:model="fieldColumnMap.business_id" id="businessId">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Location ID *" for="locationId" :error="$errors->first('fieldColumnMap.location_id')">
                                <x-input.select wire:model="fieldColumnMap.business_id" id="locationId">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Delivery address *" for="deliveryAddress" :error="$errors->first('fieldColumnMap.delivery_address')">
                                <x-input.select wire:model="fieldColumnMap.delivery_address" id="deliveryAddress">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Delivery contact" for="deliveryContact">
                                <x-input.select wire:model="fieldColumnMap.delivery_contact" id="deliveryContact" :error="$errors->first('fieldColumnMap.delivery_contact')">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Delivery note" for="deliveryNote">
                                <x-input.select wire:model="fieldColumnMap.delivery_note" id="deliveryNote" :error="$errors->first('fieldColumnMap.delivery_note')">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Collected on" for="collectedOn">
                                <x-input.select wire:model="fieldColumnMap.collected_on" id="collectedOn" :error="$errors->first('fieldColumnMap.collected_on')">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Deliver by" for="deliverBy">
                                <x-input.select wire:model="fieldColumnMap.deliver_by" id="deliverBy" :error="$errors->first('fieldColumnMap.deliver_by')">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Status" for="status">
                                <x-input.select wire:model="fieldColumnMap.status" id="status">
                                    <option disabled>Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Delivered on" for="deliveredOn">
                                <x-input.select wire:model="fieldColumnMap.delivered_on" id="deliveredOn">
                                    <option value="">Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Out for delivery on" for="outForDeliveryOn">
                                <x-input.select wire:model="fieldColumnMap.out_for_delivery_on" id="outForDeliveryOn">
                                    <option value="null">Select column...</option>
                                    @foreach($columns as $column)
                                        <option>{{ $column }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                        </div>
                        <div>
                            <x-input.group label="Reached location on" for="reachedLocationOn">
                                <x-input.select wire:model="fieldColumnMap.reached_location_on" id="reachedLocationOn">
                                    <option value="null">Select column...</option>
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
