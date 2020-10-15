<x-app-layout>
    <div class="w-full" x-data="{ openAdvancedSearch: false }">
        <div class="flex justify-between items-center">
            <x-title
                title="Packages"
                subtitle="Manage packages"
            ></x-title>
            <x-modal header="Add package">
                <x-slot name="trigger">
                    <button class="group flex items-start space-x-1 text-orange-600 focus:outline-none">
                        <x-icon type="add"/>
                        <span class="leading-tight text-gray-700 transition duration-200 group-hover:text-orange-600">Add package</span>
                    </button>
                </x-slot>
                <!-- Body -->
                <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="text-sm text-gray-600">Tracking ID</label>
                        <x-input
                            placeholder="Enter tracking ID"
                        ></x-input>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Business</label>
                        <x-select input-name="business">
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="">Select business</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="1">Yumnam Variety store</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="2">Dasys Flowers</option>
                        </x-select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Status</label>
                        <x-select input-name="status">
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="">Select status</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="dispatched">Dispatched</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="delivered">Delivered</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="processing">Processing</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="delayed">Delayed</option>
                        </x-select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Collected on</label>
                        <x-date-picker id="collectedMinDate" name="collected_on" value="{{now()->format('d/m/Y')}}"/>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Deliver by</label>
                        <x-date-picker id="collectedMaxDate" name="deliver_by" value="{{now()->addDays(3)->format('d/m/Y')}}"/>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Delivery Location</label>
                        <x-select input-name="delivery_location">
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="">Select delivery location</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="imphal-west">Imphal West</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="imphal-east">Imphal East</option>
                        </x-select>
                    </div>
                </div>

                <x-slot name="footerButton">
                    <x-button text="Add package" type="dark" class="p-3 leading-none text-sm"/>
                </x-slot>
            </x-modal>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between mt-4 md:mt-6 space-y-2 md:space-y-0">
            <div class="flex flex-col md:flex-row items-center space-x-4 space-y-2">
                <div>
                    <x-input placeholder="Search packages..." icon="search"/>
                </div>
                <button
                    class="text-gray-500 focus:outline-none"
                    @click="openAdvancedSearch = !openAdvancedSearch"
                    x-text="openAdvancedSearch ? 'Close advance search...' : 'Advanced search...'"
                ></button>
            </div>
            <div class="flex flex-col md:flex-row items-center justify-between space-x-0 space-y-2 md:space-x-2 md:space-y-0">

                <div class="flex items-center space-x-2">
                    <label for="limit" class="w-full text-right">Per page</label>
                    <x-select input-name="per_page" :initial-value="10" input-width="32">
                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="10">10</option>
                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="30">30</option>
                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="50">50</option>
                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="100">100</option>
                    </x-select>
                </div>

                <div>
                    <x-dropdown-button trigger="Bulk option" width="48">
                        <div>
                            <p class="px-2 pt-3 uppercase text-xs text-gray-600">Change status to</p>
                            <ul>
                                <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">On route</li>
                                <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Delivered</li>
                                <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Processing</li>
                                <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Delayed</li>
                            </ul>
                            <p class="px-2 pt-3 uppercase text-xs text-gray-600">Actions</p>
                            <ul>
                                <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Delete</li>
                                <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Download</li>
                            </ul>
                        </div>
                    </x-dropdown-button>
                </div>

                <div>
                    <x-button
                        icon="upload"
                        text="Import"
                        icon-width="3"
                        class="border border-gray-300 bg-white hover:bg-gray-200 rounded p-3"
                    ></x-button>
                </div>
            </div>
        </div>

        <!-- Advanced search -->
        <div x-show="openAdvancedSearch" x-cloak class="py-2">
            <div class="bg-gray-100 border border-gray-300 rounded p-4">
                <div class="flex justify-between items-center">
                    <p class="text-orange-600">Advanced search</p>
                    <button class="text-red-400 transition delay-200 hover:text-red-600">Clear filter</button>
                </div>
                <div class="grid grids-cols-2 md:grid-cols-3 gap-2 mt-4">
                    <div>
                        <label class="text-sm text-gray-600">Status</label>
                        <x-select input-name="status" initial-value="all">
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="all">All status</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="dispatched">Dispatched</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="delivered">Delivered</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="processing">Processing</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="delayed">Delayed</option>
                        </x-select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Collected on min date</label>
                        <x-date-picker id="collectedMinDate" name="collected_min_date"/>
                        {{-- <x-date-picker value="{{now()->format('d/m/Y')}}" id="date"/>--}}
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Collected on max date</label>
                        <x-date-picker id="collectedMaxDate" name="collected_max_date"/>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Business</label>
                        <x-select input-name="business" initial-value="0">
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="0">All businesses</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="1">Yumnam Variety store</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="2">Dasys Flowers</option>
                        </x-select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Deliver by min date</label>
                        <x-date-picker id="deliverMinDate" name="deliver_min_date"/>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Deliver by max date</label>
                        <x-date-picker id="deliverMaxDate" name="deliver_max_date"/>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Business Location</label>
                        <x-select input-name="business_location" initial-value="all">
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="all">All locations</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="imphal-west">Imphal West</option>
                            <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="imphal-east">Imphal East</option>
                        </x-select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Delivery Location</label>
                        <x-select input-name="delivery_location" initial-value="all">
                                <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="all">All locations</option>
                                <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="imphal-west">Imphal West</option>
                                <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="imphal-east">Imphal East</option>
                        </x-select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="mt-4">
            <x-table>
                <x-slot name="head">
                    <x-table.heading class="w-16"><x-checkbox /></x-table.heading>
                    <x-table.heading sortable>Tracking ID</x-table.heading>
                    <x-table.heading>Business</x-table.heading>
                    <x-table.heading>Location</x-table.heading>
                    <x-table.heading sortable>Collected on</x-table.heading>
                    <x-table.heading sortable>Deliver by</x-table.heading>
                    <x-table.heading sortable>Status</x-table.heading>
                    <x-table.heading class="text-right">Actions</x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @for($i = 0; $i <10; $i += 1)
                    <x-table.row class="{{ $i % 2 !== 0 ? 'bg-gray-100' : '' }}">
                        <x-table.cell class="text-sm"><x-checkbox /></x-table.cell>
                        <x-table.cell class="text-sm">IEX001234598</x-table.cell>
                        <x-table.cell class="text-sm">Yumnam Variety Store</x-table.cell>
                        <x-table.cell class="text-sm">
                            <p class="text-blue-600 font-bold">Imphal West</p>
                            <p class="flex items-start space-x-1 text-sm text-green-600 font-bold">
                                <svg class="w-3 h-auto fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 14"><path d="M10.293 13.707a1 1 0 010-1.414L12.586 10H7a7 7 0 01-7-7V1a1 1 0 012 0v2a5 5 0 005 5h5.586l-2.293-2.293a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" fill-rule="evenodd"/></svg>
                                <span>Imphal East</span>
                            </p>
                        </x-table.cell>
                        <x-table.cell class="text-sm">{{ now()->format('d/m/Y') }}</x-table.cell>
                        <x-table.cell class="text-sm">{{ now()->format('d/m/Y') }}</x-table.cell>
                        <x-table.cell class="text-sm">
                            <x-badge type="gray">Processing</x-badge>
                        </x-table.cell>
                        <x-table.cell class="text-sm">
                            <x-button-group class="justify-end">
                                <x-action-button color="orange" icon="status">
                                    <div class="w-40 leading-none">
                                        <p class="px-2 pt-3 text-xs uppercase text-gray-400">Change status to</p>
                                        <button class="w-full text-left px-2 py-3 hover:bg-gray-100">Processing</button>
                                        <button class="w-full text-left px-2 py-3 hover:bg-gray-100">Dispatched</button>
                                        <button class="w-full text-left px-2 py-3 hover:bg-gray-100">Delivered</button>
                                        <button class="w-full text-left px-2 py-3 hover:bg-gray-100">Delayed</button>
                                    </div>
                                </x-action-button>
                                <x-button icon="edit" class="text-gray-600"/>
                                <x-button icon="delete" class="text-gray-600"/>
                            </x-button-group>
                        </x-table.cell>
                    </x-table.row>
                    @endfor
                </x-slot>
            </x-table>
        </div>

    </div>
</x-app-layout>
