<div>
    <div class="w-full md:w-2/3 lg:w-1/2 mx-auto">
        <x-title
            title="Track package"
            subtitle="Track your package to view current status and location."
        ></x-title>

        <form wire:submit.prevent="track">
            <div class="flex flex-col md:flex-row items-center space-x-0 md:space-x-4 space-y-4 md:space-y-0 mt-6 md:mt-12">
                <x-input.group class="w-full">
                    <x-input.text
                        wire:model="trackingId"
                        placeholder="Enter tracking ID"
                        required
                    ></x-input.text>
                </x-input.group>
                <div class="w-full md:w-64">
                    <button wire:click.prevent="track"
                        class="p-3 w-full text-sm rounded bg-orange-600 text-gray-100 font-bold focus:outline-none transition duration-200 hover:bg-orange-700"
                    >Track</button>
                </div>
            </div>
        </form>

        @error('trackingId')
        <div>
            <span class="text-sm text-red-500 pt-1">{{ $message }}</span>
        </div>
        @enderror

        <div class="mt-4 md:mt-6" wire:loading.class.delay="opacity-50">
            @if($trackingId && $result)
                <div class="flex flex-col md:flex-row mt-2 md:mt-4 space-y-4 md:space-x-4 items-end">
                    <div class="w-full md:w-3/5">
                        <p class="text-gray-600 mb-2">Package details</p>
                        <table class="table-fixed w-full">
                            <tbody>
                            <tr>
                                <td class="border px-4 py-4 w-1/2">Tracking ID</td>
                                <td class="border px-4 py-4 w-1/2">{{ $result->tracking_id }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-4">Location</td>
                                <td class="border px-4 py-4">{{ $result->location->name }}</td>
                            </tr>
                            <tr class="bg-gray-100">
                                <td class="border px-4 py-4">Shipped date</td>
                                <td class="border px-4 py-4">{{ $result->formatDate($result->collected_on) }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-4">Expected delivery</td>
                                <td class="border px-4 py-4">{{ $result->formatDate($result->deliver_by) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="w-full md:w-2/5 flex items-start md:items-start justify-center md:justify-start">
                        <x-tracking-status :package="$result"/>
                    </div>
                </div>
            @elseif($trackingId && $searched && !$result)
                <div class="bg-gray-100 border rounded border-gray-300 px-4 py-24 md:py-32 mt-2 md:mt-4">
                    <p class="text-center text-gray-500">No results found! Please check your tracking ID.</p>
                </div>
            @else
                <div class="bg-gray-100 border rounded border-gray-300 px-4 py-24 md:py-32 mt-2 md:mt-4">
                    <p class="text-center text-gray-500">Enter a valid tracking ID above and click / press the track button to view your package status</p>
                </div>
            @endif
        </div>
    </div>
</div>
