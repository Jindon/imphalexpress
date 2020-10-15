<div class="bg-white py-1 md:py-8">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="w-full flex items-center justify-between px-4 md:px-6 py-2 md:py-0 border-b border-gray-300 md:border-none">
            <h1 class="text-lg leading-tight">Imphal <span class="font-black text-orange-600">Express</span></h1>
            <a href="/" class="md:hidden flex items-center text-gray-600 leading-none font-bold transition duration-200 hover:text-orange-600">
                <x-icon type="phone" />
                <div class="ml-2">8541230698</div>
            </a>
        </div>
        <div class="w-full overflow-hidden overflow-x-auto px-4 md:px-6 md:px-0 py-2 md:py-0">
            <div class="flex items-center space-x-8">
                <a class="font-bold {{ request()->is('/') ? 'text-orange-600' : 'text-gray-500' }}" href="/">Home</a>
                <a class="font-bold {{ request()->is('track') ? 'text-orange-600' : 'text-gray-500' }}" href="/track">Track</a>
                <a class="font-bold {{ request()->is('packages') ? 'text-orange-600' : 'text-gray-500' }}" href="/packages">Packages</a>
                <a class="font-bold {{ request()->is('settings') ? 'text-orange-600' : 'text-gray-500' }}" href="/settings/general">Settings</a>
            </div>
        </div>
        <div class="hidden md:block px-4 md:px-6">
            <a href="/" class="flex items-center text-gray-600 leading-none font-bold transition duration-200 hover:text-orange-600">
                <x-icon type="phone" />
                <div class="ml-2">8541230698</div>
            </a>
        </div>
    </div>
</div>
