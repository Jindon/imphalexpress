<x-app-layout>
    <x-settings-layout>
        <div class="w-full md:w-2/3 mx-auto mt-6 md:mt-10">
            <x-title title="General settings" title-size="lg"></x-title>
            <div class="flex flex-col space-y-4 py-4">
                <div class="grid grids-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="text-sm text-gray-600">Site name</label>
                        <x-input placeholder="Enter site name"></x-input>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Contact number</label>
                        <x-input placeholder="Enter contact number"></x-input>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Receive callback email on</label>
                        <x-input placeholder="Enter email to receive callback request on"></x-input>
                    </div>
                </div>
                <div class="flex md:justify-end items-center">
                    <x-button type="dark" text="Save" class="py-3 px-4 text-sm" />
                </div>
            </div>
            <div class="flex flex-col space-y-4 py-4 border-t border-gray-300">
                <p>Status</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    <div>
                        <x-status-badge color="gray">
                            <div class="w-full flex items-center justify-between">
                                <span>Processing</span>
                                <x-button
                                    icon="close"
                                    icon-width="3"
                                    class="text-red-400 border-none bg-red-100 transition duration-200 hover:bg-red-400 hover:text-red-100"
                                ></x-button>
                            </div>
                        </x-status-badge>
                    </div>
                    <div>
                        <x-status-badge color="blue">
                            <div class="w-full flex items-center justify-between">
                                <span>Dispatched</span>
                                <x-button
                                    icon="close"
                                    icon-width="3"
                                    class="text-red-400 border-none bg-red-100 transition duration-200 hover:bg-red-400 hover:text-red-100"
                                ></x-button>
                            </div>
                        </x-status-badge>
                    </div>
                    <div>
                        <x-status-badge color="green">
                            <div class="w-full flex items-center justify-between">
                                <span>Delivered</span>
                                <x-button
                                    icon="close"
                                    icon-width="3"
                                    class="text-red-400 border-none bg-red-100 transition duration-200 hover:bg-red-400 hover:text-red-100"
                                ></x-button>
                            </div>
                        </x-status-badge>
                    </div>
                    <div>
                        <x-status-badge color="red">
                            <div class="w-full flex items-center justify-between">
                                <span>Delayed</span>
                                <x-button
                                    icon="close"
                                    icon-width="3"
                                    class="text-red-400 border-none bg-red-100 transition duration-200 hover:bg-red-400 hover:text-red-100"
                                ></x-button>
                            </div>
                        </x-status-badge>
                    </div>
                    <div class="p-2 rounded border-dashed border-2 border-gray-300 text-gray-500 transition duration-200 hover:bg-gray-100 hover:text-orange-600 hover:border-orange-600 cursor-pointer">
                        <div>
                            <span>+ Add status</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col space-y-4 py-4 border-t border-gray-300">
            <p>Locations</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                <div class="p-2 rounded border-2 border-gray-300 text-gray-600">
                        <div class="w-full flex items-center justify-between">
                            <span>Imphal west</span>
                            <x-button
                                icon="close"
                                icon-width="3"
                                class="text-red-400 border-none bg-red-100 transition duration-200 hover:bg-red-400 hover:text-red-100"
                            ></x-button>
                        </div>
                </div>
                <div class="p-2 rounded border-dashed border-2 border-gray-300 text-gray-500 transition duration-200 hover:bg-gray-100 hover:text-orange-600 hover:border-orange-600 cursor-pointer">
                    <div>
                        <span>+ Add location</span>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </x-settings-layout>
</x-app-layout>
