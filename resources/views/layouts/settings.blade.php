<x-app-layout>
    <div class="w-full">
        <div class="flex justify-between items-center">
            <x-title
                title="Settings"
                subtitle="Manage application settings"
            ></x-title>
        </div>

        <div class="w-full py-4 border-b border-gray-300 overflow-hidden overflow-x-auto">
            <div class="flex items-center space-x-8 text-gray-600">
                @if(auth()->user()->role == 'superadmin')
                    <a href="{{ route('admin.settings.general') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/general') ? 'text-orange-600' : '' }}">General</a>
                    <a href="{{ route('admin.settings.businesses') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/businesses') ? 'text-orange-600' : '' }}">Businesses</a>
                    <a href="{{ route('admin.settings.users') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/users') ? 'text-orange-600' : '' }}">Users</a>
                @endif
                <a href="{{ route('admin.settings.account') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/account') ? 'text-orange-600' : '' }}">Account</a>
            </div>
        </div>

        <div class="mt-2 md:mt-4">
            {{ $slot }}
        </div>

    </div>
</x-app-layout>
