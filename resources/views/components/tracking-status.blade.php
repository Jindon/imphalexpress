@php
$processing = ['processing','received','dispatched','delivered','delayed'];
$received = ['received','dispatched','delivered','delayed'];
$dispatched = ['dispatched','delivered','delayed'];
$delivered = ['delivered'];
@endphp

<div>
    <div class="flex flex-col items-start">
        <div class="flex flex-row items-center space-x-4">
            <div class="w-10 h-10 rounded-full @if(in_array($package->status, $delivered)) bg-green-400 @else bg-gray-400 @endif"></div>
            @if(in_array($package->status, $delivered))
            <div class="flex flex-col">
                <p class="text-sm font-bold text-green-500">Out for delivery</p>
                <p class="text-xs leading-none text-green-500">on {{ $package->humanDate($package->out_for_delivery_on) }}</p>
            </div>
            @else
                <div class="flex flex-col">
                    <p class="text-sm font-bold text-gray-500">Expected delivery</p>
                    <p class="text-xs leading-none text-gray-500">by {{ $package->humanDate($package->deliver_by) }}</p>
                </div>
            @endif
        </div>
        <div class="flex flex-row items-center space-x-4">
            <div class="ml-4 h-6 p-1 @if(in_array($package->status, $dispatched)) bg-green-400 @else bg-gray-400 @endif"></div>
        </div>
        <div class="flex flex-row items-center space-x-4">
            <div class="w-10 h-10 rounded-full @if(in_array($package->status, $dispatched)) bg-green-400 @else bg-gray-400 @endif"></div>
            @if(in_array($package->status, $dispatched))
            <div class="flex flex-col">
                <p class="text-sm font-bold text-green-500">Out for delivery</p>
                <p class="text-xs leading-none text-green-500">on {{ $package->humanDate($package->out_for_delivery_on) }}</p>
            </div>
            @else
                <p class="text-sm font-bold text-gray-500">Waiting to dispatch</p>
            @endif
        </div>
        <div class="flex flex-row items-center space-x-4">
            <div class="ml-4 h-6 p-1 @if(in_array($package->status, $received)) bg-green-400 @else bg-gray-400 @endif"></div>
        </div>
        <div class="flex flex-row items-center space-x-4">
            <div class="w-10 h-10 rounded-full @if(in_array($package->status, $received)) bg-green-400 @else bg-gray-400 @endif"></div>
            @if(in_array($package->status, $received))
            <div class="flex flex-col">
                <p class="text-sm font-bold text-green-500">Reached {{ $package->location->name }}</p>
                <p class="text-xs leading-none text-green-500">on {{ $package->humanDate($package->reached_location_on) }}</p>
            </div>
            @else
                <p class="text-sm font-bold text-gray-500">Waiting to reach {{ $package->location->name }}</p>
            @endif
        </div>
        <div class="flex flex-row items-center space-x-4">
            <div class="ml-4 h-6 p-1 @if(in_array($package->status, $processing)) bg-green-400 @else bg-gray-400 @endif"></div>
        </div>
        <div class="flex flex-row items-center space-x-4">
            <div class="w-10 h-10 rounded-full @if(in_array($package->status, $processing)) bg-green-400 @else bg-gray-400 @endif"></div>
            <p class="text-sm font-bold text-green-500">Processing</p>
        </div>
    </div>
</div>
