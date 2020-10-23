<div class="bg-white py-1 md:py-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="w-full md:w-1/3 flex items-center justify-between px-4 md:px-6 py-2 md:py-0 border-b border-gray-300 md:border-none">
            <h1 class="text-lg leading-tight">Imphal <span class="font-black text-orange-600">Express</span></h1>
            <a href="/" class="md:hidden flex items-center text-gray-600 leading-none font-bold transition duration-200 hover:text-orange-600">
                <x-icon type="phone" />
                <div class="ml-2">8541230698</div>
            </a>
        </div>
        <div class="w-full md:w-1/3 overflow-hidden overflow-x-auto px-4 md:px-6 md:px-0 py-2 md:py-0">
            <div class="flex items-center md:justify-center space-x-8">
                <a class="font-bold {{ request()->is('/') ? 'text-orange-600' : 'text-gray-500' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                <a class="font-bold {{ request()->is('track') ? 'text-orange-600' : 'text-gray-500' }}" href="{{ route('track') }}">{{ __('Track') }}</a>
                @auth
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                        <a class="font-bold {{ request()->is('admin/packages') ? 'text-orange-600' : 'text-gray-500' }}" href="{{ route('admin.packages') }}">{{ __('Packages') }}</a>
                    @endif
                    @if(auth()->user()->role == 'superadmin')
                        <a class="font-bold {{ request()->is('settings*') ? 'text-orange-600' : 'text-gray-500' }}" href="/settings/general">{{ __('Settings') }}</a>
                    @endif
                    <a class="font-bold text-gray-500" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <x-form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden"></x-form>
                @endauth
            </div>
        </div>
        <div class="w-1/3 hidden md:block px-4 md:px-6">
            <a href="tel:+918794205728" class="flex items-center justify-end text-gray-600 leading-none font-bold transition duration-200 hover:text-orange-600">
                <x-icon type="phone" />
                <div class="ml-2">{{ siteContactNumber() }}</div>
            </a>
        </div>
    </div>
</div>
