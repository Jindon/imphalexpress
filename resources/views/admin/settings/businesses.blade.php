<x-app-layout>
    <x-settings-layout>
        <div class="w-full" x-data="{ openAdvancedSearch: false }">

            <div class="flex flex-col md:flex-row items-center justify-between mt-4 md:mt-6">
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
                        <x-button.dropdown trigger="Bulk option" width="48">
                            <div>
                                <p class="px-2 pt-3 uppercase text-xs text-gray-600">Change status to</p>
                                <ul>
                                    <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Active</li>
                                    <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Disabled</li>
                                </ul>
                                <p class="px-2 pt-3 uppercase text-xs text-gray-600">Actions</p>
                                <ul>
                                    <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Delete</li>
                                    <li class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100">Download</li>
                                </ul>
                            </div>
                        </x-button.dropdown>
                    </div>

                    <div>
{{--                        <x-modal header="Add package" width="2/5">--}}
{{--                            <x-slot name="trigger">--}}
{{--                                <x-button--}}
{{--                                    icon="add"--}}
{{--                                    class="border border-gray-300 border-orange-600 text-orange-600 hover:bg-orange-700 hover:text-orange-100 rounded p-3"--}}
{{--                                ></x-button>--}}
{{--                            </x-slot>--}}
{{--                            <!-- Body -->--}}
{{--                            <div class="grid grids-cols-1 md:grid-cols-2 gap-2">--}}
{{--                                <div>--}}
{{--                                    <label class="text-sm text-gray-600">Business Name</label>--}}
{{--                                    <x-input--}}
{{--                                        placeholder="Enter business name"--}}
{{--                                    ></x-input>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <label class="text-sm text-gray-600">Business Location</label>--}}
{{--                                    <x-select input-name="delivery_location">--}}
{{--                                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="">Select business location</option>--}}
{{--                                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="imphal-west">Imphal West</option>--}}
{{--                                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="imphal-east">Imphal East</option>--}}
{{--                                    </x-select>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <label class="text-sm text-gray-600">Business Phone</label>--}}
{{--                                    <x-input--}}
{{--                                        icon="phone"--}}
{{--                                        placeholder="Enter business phone"--}}
{{--                                    ></x-input>--}}
{{--                                </div>--}}
{{--                                <div>--}}
{{--                                    <label class="text-sm text-gray-600">Status</label>--}}
{{--                                    <x-select input-name="status">--}}
{{--                                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="active">Active</option>--}}
{{--                                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="disabled">Disabled</option>--}}
{{--                                    </x-select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <x-slot name="footerButton">--}}
{{--                                <x-button text="Add business" type="dark" class="p-3 leading-none text-sm"/>--}}
{{--                            </x-slot>--}}
{{--                        </x-modal>--}}
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
                                <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="active">Active</option>
                                <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="disabled">Diabled</option>
                            </x-select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Added on min date</label>
                            <x-date-picker id="collectedMinDate" name="added_min_date"/>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Added on max date</label>
                            <x-date-picker id="collectedMaxDate" name="added_max_date"/>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600">Business Location</label>
                            <x-select input-name="business_location" initial-value="all">
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
                        <x-table.heading class="md:w-2/5" sortable>Name</x-table.heading>
                        <x-table.heading sortable>Location</x-table.heading>
                        <x-table.heading sortable>Added on</x-table.heading>
                        <x-table.heading sortable>Status</x-table.heading>
                        <x-table.heading class="text-right">Actions</x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @for($i = 0; $i <10; $i += 1)
                            <x-table.row class="{{ $i % 2 !== 0 ? 'bg-gray-100' : '' }}">
                                <x-table.cell class="text-sm"><x-checkbox /></x-table.cell>
                                <x-table.cell class="text-sm">Yumnam Variety Store</x-table.cell>
                                <x-table.cell class="text-sm">
                                    <p class="text-blue-600 font-bold">Imphal West</p>
                                </x-table.cell>
                                <x-table.cell class="text-sm">{{ now()->format('d/m/Y') }}</x-table.cell>
                                <x-table.cell class="text-sm">
                                    <x-badge type="green">Active</x-badge>
                                </x-table.cell>
                                <x-table.cell class="text-sm">
                                    <x-button.group class="justify-end">
                                        <x-button.action icon="status">
                                            <div class="w-40 leading-none">
                                                <p class="px-2 pt-3 text-xs uppercase text-gray-400">Change status to</p>
                                                <button class="w-full text-left px-2 py-3 hover:bg-gray-100">Active</button>
                                                <button class="w-full text-left px-2 py-3 hover:bg-gray-100">Disabled</button>
                                            </div>
                                        </x-button.action>
                                        <x-button.icon.edit class="text-gray-600"/>
                                        <x-button.icon.delete class="text-gray-600"/>
                                    </x-button.group>
                                </x-table.cell>
                            </x-table.row>
                        @endfor
                    </x-slot>
                </x-table>
            </div>

        </div>
    </x-settings-layout>
</x-app-layout>
