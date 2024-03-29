<div>
    <div class="w-full" x-data="{ openAdvancedSearch: false }">

        <div class="flex flex-col md:flex-row items-center justify-between mt-4 md:mt-6">
            <div class="flex flex-col md:flex-row items-center space-x-4 space-y-2">
                <div>
                    <x-input.text wire:model="filters.search" placeholder="Search packages..." icon="search">
                        <x-slot name="endingAddon"><x-icon type="search" /></x-slot>
                    </x-input.text>
                </div>
            </div>
            <div class="flex flex-col md:flex-row items-center justify-between space-x-0 space-y-2 md:space-x-2 md:space-y-0">

                <div class="flex items-center space-x-2">
                    <label for="limit" class="w-full text-right">Per page</label>
                    <x-input.select id="limit" wire:model="perPage" input-width="32">
                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="10">10</option>
                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="25">25</option>
                        <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="50">50</option>
                    </x-input.select>
                </div>

                <div>
                    <x-button.dropdown trigger="Bulk option" width="48">
                        <div class="py-2">
                            <button wire:click="$toggle('showConfirmDeleteSelected', true)" class="w-full px-4 py-2 text-left pointer cursor-pointer text-sm hover:bg-gray-100">Delete</button>
                            <button wire:click="exportSelected" class="w-full px-4 py-2 text-left pointer cursor-pointer text-sm hover:bg-gray-100">Export CSV</button>
                        </div>
                    </x-button.dropdown>
                </div>
                <div>
                    <x-button.icon.add wire:click="toggleShowForm" icon-width="5" class="p-3" />
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="mt-4">
            <x-table>
                <x-slot name="head">
                    <x-table.heading class="w-16"><x-checkbox wire:model="selectPage"/></x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">Name</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('location_id')" :direction="$sorts['location_id'] ?? null">Location</x-table.heading>
                    <x-table.heading>Phone</x-table.heading>
                    <x-table.heading>Email</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sorts['created_at'] ?? null">Added on</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">Status</x-table.heading>
                    <x-table.heading class="text-right">Actions</x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @if($users->total() > 0 && $selectPage)
                        <x-table.row>
                            <x-table.cell colspan="8" class="bg-orange-100">
                                @unless($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $users->count() }}</strong> users, do you want to select all <strong>{{ $users->total() }}</strong> users?</span>
                                        <button wire:click="selectAll" class="ml-2 hover:underline text-blue-600">Select all</button>
                                    </div>
                                @else
                                    <span>You have selected all <strong>{{ $users->total() }}</strong> users.</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endif

                    @forelse($users as $index => $user)
                        <x-table.row class="{{ $index % 2 !== 0 ? 'bg-gray-100' : '' }}" wire:loading.class.delay="opacity-50" wire:key="row-{{ $user->id }}">
                            <x-table.cell class="text-sm"><x-checkbox wire:model="selected" value="{{ $user->id }}"/></x-table.cell>
                            <x-table.cell class="text-sm">{{ $user->name }}</x-table.cell>
                            <x-table.cell class="text-sm">{{ $user->location->name }}</x-table.cell>
                            <x-table.cell class="text-sm">{{ $user->phone }}</x-table.cell>
                            <x-table.cell class="text-sm">{{ $user->email }}</x-table.cell>
                            <x-table.cell class="text-sm">{{ $user->created_at_formatted }}</x-table.cell>
                            <x-table.cell class="text-sm">
                                <x-badge :color="$user->status ? 'green' : 'red'">{{ $user->getStatus() }}</x-badge>
                            </x-table.cell>
                            <x-table.cell class="text-sm">
                                <x-button.group class="justify-end">
                                    <x-button.action icon="status">
                                        <div class="w-40 leading-none">
                                            <p class="px-2 pt-3 text-xs uppercase text-gray-400">Change status to</p>
                                            <button wire:click="changeStatus({{ $user->id }}, 1)" class="w-full text-left px-2 py-3 hover:bg-gray-100">Active</button>
                                            <button wire:click="changeStatus({{ $user->id }}, 0)" class="w-full text-left px-2 py-3 hover:bg-gray-100">Disabled</button>
                                        </div>
                                    </x-button.action>
                                    <x-button.icon.edit wire:click="editUser({{ $user->id }})" class="text-gray-600"/>
                                    <x-button.icon.delete wire:click="confirmDelete({{ $user->id }})" class="text-gray-600"/>
                                </x-button.group>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="8">
                                <div class="w-full flex justify-center py-10 text-gray-500">
                                    No users found..
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

    </div>

    <!-- Business form modal -->
    <x-modal wire:model="showForm">
        <div class="p-4 flex justify-between items-center">
            <x-title title="Save user" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="toggleShowForm"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            <form wire:submit.prevent="save">
                <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <x-input.group type="text" label="Full name *" for="name" :error="$errors->first('name')">
                            <x-input.text wire:model="name" id="name" placeholder="Enter full name" required></x-input.text>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Location *" for="location" :error="$errors->first('location_id')">
                            <x-input.select wire:model="location_id" id="location">
                                <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="">Select location</option>
                                @foreach($locations as $location)
                                    <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="{{ $location->id }}">
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Phone" for="phone" :error="$errors->first('phone')">
                            <x-input.text wire:model="phone" id="phone" placeholder="Enter user phone"></x-input.text>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Email address *" for="email" :error="$errors->first('email')">
                            <x-input.text wire:model="email" id="email" type="email" placeholder="user@email.com" required></x-input.text>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Password *" for="password" :error="$errors->first('password')">
                            <x-input.password wire:model="password" id="password" placeholder="********" required></x-input.password>
                        </x-input.group>
                    </div>
                    <div>
                        <x-input.group type="text" label="Status *" for="status" :error="$errors->first('status')">
                            <x-input.select id="status" wire:model="status">
                                <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="1">Active</option>
                                <option class="px-2 py-1 pointer cursor-pointer text-sm hover:bg-gray-100" value="0">Disabled</option>
                            </x-input.select>
                        </x-input.group>
                    </div>
                </div>
                <input type="submit" class="hidden">
            </form>
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex md:justify-end items-center space-x-2">
                <x-button.default wire:click="toggleShowForm">Nevermind</x-button.default>
                <x-button.dark wire:click="save">Save user</x-button.dark>
            </div>
        </div>
    </x-modal>

    <!-- Confirm delete business modal -->
    <x-modal wire:model.defer="showConfirmDelete" max-width="md">
        <div class="p-4 flex justify-between items-center">
            <x-title title="Delete user" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="$set('showConfirmDelete', false)"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            Are you sure you want to delete this user? This action is not irreversible.
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex md:justify-end items-center space-x-2">
                <x-button.default wire:click="$set('showConfirmDelete', false)">Nevermind</x-button.default>
                <x-button.danger wire:click="delete">Delete</x-button.danger>
            </div>
        </div>
    </x-modal>

    <!-- Confirm delete selected businesses modal -->
    <x-modal wire:model.defer="showConfirmDeleteSelected" max-width="md">
        <div class="p-4 flex justify-between items-center">
            <x-title title="Delete selected users" title-size="text-lg md:text-xl"></x-title>
            <div>
                <x-button.icon.close icon-width="3" class="p-2" wire:click="$set('showConfirmDeleteSelected', false)"></x-button.icon.close>
            </div>
        </div>
        <div class="p-4">
            Are you sure you want to delete the selected users? This action is not irreversible.
        </div>
        <div class="p-4 bg-gray-100">
            <div class="flex md:justify-end items-center space-x-2">
                <x-button.default wire:click="$set('showConfirmDeleteSelected', false)">Nevermind</x-button.default>
                <x-button.danger wire:click="deleteSelected">Delete</x-button.danger>
            </div>
        </div>
    </x-modal>

</div>
