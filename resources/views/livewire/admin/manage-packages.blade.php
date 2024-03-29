<div class="w-full" x-data="{ openAdvancedSearch: false }">
    <div class="flex items-center justify-between">
        <x-title
            title="Packages"
            subtitle="Manage packages"
        ></x-title>
        <x-button.link wire:click="toggleShowForm" class="text-orange-500">+ Add package</x-button.link>
    </div>

    <div class="flex flex-col items-center justify-between mt-4 md:flex-row md:mt-6">
        <div class="flex flex-col items-center space-x-4 space-y-2 md:flex-row">
            <div>
                <x-input.text wire:model="filters.search" placeholder="Search packages..." icon="search">
                    <x-slot name="endingAddon"><x-icon type="search" /></x-slot>
                </x-input.text>
            </div>
            <button
                class="text-gray-500 focus:outline-none"
                @click="openAdvancedSearch = !openAdvancedSearch"
                x-text="openAdvancedSearch ? 'Close advance search...' : 'Advanced search...'"
            ></button>
        </div>
        <div class="flex flex-col items-center justify-between space-x-0 space-y-2 md:flex-row md:space-x-2 md:space-y-0">

            <div class="flex items-center space-x-2">
                <label for="limit" class="w-full text-right">Per page</label>
                <x-input.select id="limit" wire:model="perPage" input-width="32">
                    <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="10">10</option>
                    <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="25">25</option>
                    <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="50">50</option>
                </x-input.select>
            </div>

            <div>
                <x-button.dropdown trigger="Bulk option" width="48">
                    <div class="py-2">
                        <button wire:click="$toggle('showConfirmDeleteSelected', true)" class="w-full px-4 py-2 text-sm text-left cursor-pointer pointer hover:bg-gray-100">Delete</button>
                        <button wire:click="exportSelected" class="w-full px-4 py-2 text-sm text-left cursor-pointer pointer hover:bg-gray-100">Export CSV</button>
                    </div>
                </x-button.dropdown>
            </div>
            <div>
                {{-- <livewire:admin.import-packages /> --}}
            </div>
        </div>
    </div>

    <!-- Advanced search -->
    <div x-show="openAdvancedSearch" x-cloak class="py-2">
        <div class="p-4 bg-gray-100 border border-gray-300 rounded">
            <div class="flex items-center justify-between">
                <p class="text-orange-600">Advanced search</p>
                <button wire:click="resetFilters" class="text-red-400 transition delay-200 hover:text-red-600 focus:outline-none">Clear filter</button>
            </div>
            <div class="grid gap-2 mt-4 grids-cols-2 md:grid-cols-3">
                <div>
                    <x-input.group label="Status" for="status">
                        <x-input.select wire:model="filters.status" id="status">
                            <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="">All status</option>
                            @foreach(\App\Models\Package::STATUSES as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Collected on min date" for="collectedMinDate">
                        <x-input.date wire:model="filters.collectedMinDate" id="collectedMinDate"/>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Collected on max date" for="collectedMaxDate">
                        <x-input.date wire:model="filters.collectedMaxDate" id="collectedMaxDate"/>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Business" for="business">
                        <x-input.select wire:model="filters.business" id="business">
                            <option value="">All businesses</option>
                            @foreach($businesses as $key => $business)
                                <option value="{{ $key }}">{{ $business->name }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Deliver by min date" for="deliverByMinDate">
                        <x-input.date wire:model="filters.deliverByMinDate" id="deliverByMinDate"/>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Deliver by max date" for="deliverByMaxDate">
                        <x-input.date wire:model="filters.deliverByMaxDate" id="deliverByMaxDate"/>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Business Location" for="businessLocation">
                        <x-input.select wire:model="filters.businessLocation" id="businessLocation">
                            <option value="">All locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="Delivery Location" for="deliveryLocation">
                        <x-input.select wire:model="filters.deliveryLocation" id="deliveryLocation">
                            <option value="">All businesses</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>
                <div>
                    <x-input.group label="COD" for="cashOnDelivery">
                        <x-input.select wire:model="filters.cod" id="cashOnDelivery">
                            <option value="">All</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </x-input.select>
                    </x-input.group>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="mt-4">
        <x-table>
            <x-slot name="head">
                <x-table.heading class="w-16"><x-checkbox wire:model="selectPage"/></x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tracking_id')" :direction="$sorts['tracking_id'] ?? null">Tracking ID</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('business_id')" :direction="$sorts['business_id'] ?? null">Business</x-table.heading>
                <x-table.heading>Location</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('collected_on')" :direction="$sorts['collected_on'] ?? null">Collected on</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('deliver_by')" :direction="$sorts['deliver_by'] ?? null">Deliver by</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">Status</x-table.heading>
                <x-table.heading>Charge</x-table.heading>
                <x-table.heading>COD</x-table.heading>
                <x-table.heading class="text-right">Actions</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @if($packages->total() > 0 && $selectPage)
                    <x-table.row>
                        <x-table.cell colspan="7" class="bg-orange-100">
                            @unless($selectAll)
                                <div>
                                    <span>You have selected <strong>{{ $packages->count() }}</strong> packages, do you want to select all <strong>{{ $packages->total() }}</strong> packages?</span>
                                    <button wire:click="selectAll" class="ml-2 text-blue-600 hover:underline">Select all</button>
                                </div>
                            @else
                                <span>You have selected all <strong>{{ $packages->total() }}</strong> packages.</span>
                            @endif
                        </x-table.cell>
                    </x-table.row>
                @endif
                @forelse($packages as $index => $package)
                    <x-table.row class="{{ $index % 2 !== 0 ? 'bg-gray-100' : '' }}" wire:loading.class.delay="opacity-50" wire:key="row-{{ $package->id }}">
                        <x-table.cell class="text-sm"><x-checkbox wire:model="selected" value="{{ $package->id }}"/></x-table.cell>
                        <x-table.cell class="text-sm">{{ $package->tracking_id }}</x-table.cell>
                        <x-table.cell class="text-sm">{{ $package->business->name }}</x-table.cell>
                        <x-table.cell class="text-sm">
                            <p class="font-bold text-blue-600">{{ $package->business->location->name }}</p>
                            <p class="flex items-start space-x-1 text-sm font-bold text-green-600">
                                <svg class="w-3 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 14"><path d="M10.293 13.707a1 1 0 010-1.414L12.586 10H7a7 7 0 01-7-7V1a1 1 0 012 0v2a5 5 0 005 5h5.586l-2.293-2.293a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" fill-rule="evenodd"/></svg>
                                <span>{{ $package->location->name }}</span>
                            </p>
                        </x-table.cell>
                        <x-table.cell class="text-sm">{{ $package->formatDate($package->collected_on) }}</x-table.cell>
                        <x-table.cell class="text-sm">{{ $package->formatDate($package->deliver_by) }}</x-table.cell>
                        <x-table.cell class="text-sm">
                            <x-badge color="{{App\Models\Package::STATUS_COLORS[$package->status]}}">{{ App\Models\Package::STATUSES[$package->status] }}</x-badge>
                        </x-table.cell>
                        <x-table.cell class="text-sm">
                            @if($package->cod)
                                <p class="font-bold leading-none text-green-600">₹{{ $package->cod_amount }}</p>
                            @endif
                            <p class="text-xs font-bold text-blue-600">{{ $package->cod ? '+' : '' }} ₹{{ $package->delivery_charge }}</p>
                        </x-table.cell>
                        <x-table.cell class="text-sm"><x-badge color="{{ $package->cod ? 'green' : 'red' }}">{{ $package->isCOD() }}</x-badge></x-table.cell>
                        <x-table.cell class="text-sm">
                            <x-button.group class="justify-end">
                                <x-button.action icon="status">
                                    <div class="w-40 leading-none">
                                        <p class="px-2 pt-3 text-xs text-gray-400 uppercase">Change status to</p>
                                        @foreach(App\Models\Package::STATUSES as $key => $status)
                                        <button wire:click="toggleShowStatusForm({{ $package->id }}, '{{ $key }}')"
                                                class="w-full px-2 py-3 text-left hover:bg-gray-100 disabled:opacity-50"
                                                @if($package->status === $key) disabled @endif
                                        >
                                            {{ $status }}
                                        </button>
                                        @endforeach
                                    </div>
                                </x-button.action>
                                <x-button.icon.edit wire:click="editPackage({{ $package->id }})" class="text-gray-600"/>
                                <x-button.icon.delete wire:click="confirmDelete({{ $package->id }})" class="text-gray-600"/>
                            </x-button.group>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="8">
                            <div class="flex justify-center w-full py-10 text-gray-500">
                                No package found..
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>

        <div class="mt-4">
            {{ $packages->links() }}
        </div>
    </div>

    <!-- Package form modal -->
    <x-modal wire:model="showForm">
        <div class="flex items-center justify-between p-4">
            <x-title title="Save package" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="toggleShowForm"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            <form wire:submit.prevent="save">
                <div class="grid gap-2 grids-cols-1 md:grid-cols-2">
                    <div>
                        <x-input.group type="text" label="Tracking ID *" for="trackingId" :error="$errors->first('tracking_id')">
                            <x-input.text wire:model="tracking_id" id="trackingId" placeholder="Enter tracking ID" required></x-input.text>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group label="Status *" for="status" :error="$errors->first('status')">
                            <x-input.select id="status" wire:model="status">
                                @foreach(\App\Models\Package::STATUSES as $key => $status)
                                    <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="{{ $key }}">
                                        {{ $status }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group label="COD *" for="cod" :error="$errors->first('cod')">
                            <x-input.select wire:model="cod" id="cod">
                                <option class="px-2 text-sm cursor-pointer pointer hover:bg-gray-100" value="{{ false }}">No</option>
                                <option class="px-2 text-sm cursor-pointer pointer hover:bg-gray-100" value="{{ true }}">Yes</option>
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div>
                        @if($cod)
                            <x-input.group type="text" label="COD amount *" for="codAmount" :error="$errors->first('cod_amount')">
                                <x-input.text wire:model="cod_amount" id="codAmount" placeholder="Enter package cod amount"></x-input.text>
                            </x-input.group>
                        @endif
                    </div>
                    <div>
                        <x-input.group label="Business *" for="businessId" :error="$errors->first('business_id')">
                            <x-input.select wire:model="business_id" id="businessId">
                                <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="">Select business</option>
                                @foreach($businesses as $business)
                                    <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="{{ $business->id }}">
                                        {{ $business->name }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group label="Delivery location *" for="location" :error="$errors->first('location_id')">
                            <x-input.select wire:model="location_id" id="location">
                                <option class="px-2 text-sm cursor-pointer pointer hover:bg-gray-100" value="">Select location</option>
                                @foreach($locations as $location)
                                    <option class="px-2 py-1 text-sm cursor-pointer pointer hover:bg-gray-100" value="{{ $location->id }}">
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <x-input.group label="Delivery address *" for="deliveryAddress" :error="$errors->first('delivery_address')">
                            <x-input.textarea wire:model="delivery_address" id="deliveryAddress" placeholder="Enter delivery address" rows="2" required></x-input.textarea>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Delivery contact *" for="deliveryContact" :error="$errors->first('delivery_contact')">
                            <x-input.text wire:model="delivery_contact" id="deliveryContact" icon="phone" placeholder="Enter delivery contact" required></x-input.text>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Delivery note" for="deliveryNote" :error="$errors->first('delivery_note')">
                            <x-input.text wire:model="delivery_note" id="deliveryNote" icon="phone" placeholder="Enter delivery note"></x-input.text>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group label="Collected on *" for="collectedOn" :error="$errors->first('collected_on')">
                            <x-input.date wire:model="collected_on" id="collectedOn" required/>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group label="Deliver by *" for="deliverBy" :error="$errors->first('deliver_by')">
                            <x-input.date wire:model="deliver_by" id="deliverBy" required/>
                        </x-input.group>
                    </div>
                </div>
                <input type="submit" class="hidden">
            </form>
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex items-center space-x-2 md:justify-end">
                <x-button.default wire:click="toggleShowForm">Nevermind</x-button.default>
                <x-button.dark wire:click="save">Save package</x-button.dark>
            </div>
        </div>
    </x-modal>

    <!-- Package status form modal -->
    <x-modal wire:model="showStatusForm">
        <div class="flex items-center justify-between p-4">
            <x-title title="Update status to {{ $editId && $changeStatus ? \App\Models\Package::STATUSES[$changeStatus] : '' }}" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="toggleShowStatusForm"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            <form wire:submit.prevent="changeStatus">
                <div class="grid gap-2 grids-cols-1 md:grid-cols-2">
                    <div>
                        <x-input.group type="text" label="Collected on *" for="statusCollectedOn" :error="$errors->first('collected_on')">
                            <x-input.date wire:model="collected_on" id="statusCollectedOn" required/>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Deliver by *" for="statusDeliverBy" :error="$errors->first('deliver_by')">
                            <x-input.date wire:model="deliver_by" id="statusDeliverBy" required/>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Reached location on" for="reachedLocationOn" :error="$errors->first('reached_location_on')">
                            <x-input.date wire:model="reached_location_on" id="reachedLocationOn"/>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Out for delivery on" for="outForDeliveryOn" :error="$errors->first('out_for_delivery_on')">
                            <x-input.date wire:model="out_for_delivery_on" id="outForDeliveryOn"/>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Delivered on" for="deliveredOn" :error="$errors->first('delivered_on')">
                            <x-input.date wire:model="delivered_on" id="deliveredOn"/>
                        </x-input.group>
                    </div>
                </div>
                <input type="submit" class="hidden">
            </form>
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex items-center space-x-2 md:justify-end">
                <x-button.default wire:click="toggleShowStatusForm">Nevermind</x-button.default>
                <x-button.dark wire:click="changeStatus">Update status</x-button.dark>
            </div>
        </div>
    </x-modal>

    <!-- Confirm delete modal -->
    <x-modal wire:model.defer="showConfirmDelete" max-width="md">
        <div class="flex items-center justify-between p-4">
            <x-title title="Delete business" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="$set('showConfirmDelete', false)"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            Are you sure you want to delete this business? This action is not irreversible.
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex items-center space-x-2 md:justify-end">
                <x-button.default wire:click="$set('showConfirmDelete', false)">Nevermind</x-button.default>
                <x-button.danger wire:click="delete">Delete</x-button.danger>
            </div>
        </div>
    </x-modal>

    <!-- Confirm delete selected businesses modal -->
    <x-modal wire:model.defer="showConfirmDeleteSelected" max-width="md">
        <div class="flex items-center justify-between p-4">
            <x-title title="Delete selected packages" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="$set('showConfirmDeleteSelected', false)"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            Are you sure you want to delete the selected packages? This action is not irreversible.
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex items-center space-x-2 md:justify-end">
                <x-button.default wire:click="$set('showConfirmDeleteSelected', false)">Nevermind</x-button.default>
                <x-button.danger wire:click="deleteSelected">Delete</x-button.danger>
            </div>
        </div>
    </x-modal>

</div>
