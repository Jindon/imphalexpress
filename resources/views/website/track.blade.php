<x-app-layout>
    <div class="w-full md:w-2/3 lg:w-1/2 mx-auto">
        <x-title
            title="Track package"
            subtitle="Track your package to view current status and location."
        ></x-title>

        <div class="flex flex-col md:flex-row items-center space-x-0 md:space-x-4 space-y-4 md:space-y-0 mt-6 md:mt-12">
            <input class="p-2 w-full rounded border border-gray-300 bg-gray-100 text-lg placeholder-gray-400" type="text" placeholder="Enter tracking ID">
            <div class="w-full md:w-64">
                <button class="p-3 w-full rounded bg-orange-600 text-gray-100 font-bold transition duration-200 hover:bg-orange-700">Track</button>
            </div>
        </div>

        <div class="mt-4 md:mt-6">
            <p class="text-gray-600">Tracking details</p>
            @if(false)
                <div class="mt-2 md:mt-4">
                <table class="table-fixed w-full">
                    <tbody>
                    <tr>
                        <td class="border px-4 py-4 w-2/5">Tracking ID</td>
                        <td class="border px-4 py-4 w-3/5">IEX00125487</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="border px-4 py-4">Status</td>
                        <td class="border px-4 py-4">On route</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-4">Location</td>
                        <td class="border px-4 py-4">Imphal West</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="border px-4 py-4">Shipped date</td>
                        <td class="border px-4 py-4">10/10/2020</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-4">Expected delivery</td>
                        <td class="border px-4 py-4">14/10/2020</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            @else
                <div class="bg-gray-100 border rounded border-gray-300 px-4 py-24 md:py-32 mt-2 md:mt-4">
                    <p class="text-center text-gray-500">Enter you tracking ID above and click / press the track button to view your package status</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
