<x-app-layout>
    <div class="w-full">
        <div class="flex items-center justify-between">
            <x-title
                title="Settings"
                subtitle="Manage application settings"
            ></x-title>
        </div>

        <div class="w-full py-4 overflow-hidden overflow-x-auto border-b border-gray-300">
            <div class="flex items-center space-x-8 text-gray-600">
                @if(auth()->user()->role == 'superadmin')
                    <a href="{{ route('admin.settings.general') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/general') ? 'text-orange-600' : '' }}">{{ __('General') }}</a>
                    <a href="{{ route('admin.settings.businesses') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/businesses') ? 'text-orange-600' : '' }}">{{ __('Businesses') }}</a>
                    <a href="{{ route('admin.settings.pricing') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/pricing') ? 'text-orange-600' : '' }}">{{ __('Pricing') }}</a>
                    <a href="{{ route('admin.settings.users') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/users') ? 'text-orange-600' : '' }}">{{ __('Users') }}</a>
                @endif
                <a href="{{ route('admin.settings.account') }}" class="font-bold transition duration-200 hover:text-orange-600 {{ request()->is('settings/account') ? 'text-orange-600' : '' }}">{{ __('Account') }}</a>
            </div>
        </div>

        <div class="mt-2 md:mt-4">
            {{ $slot }}
        </div>

    </div>
</x-app-layout>
