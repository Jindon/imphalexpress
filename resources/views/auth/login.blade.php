<x-guest-layout>
    <div class="w-full h-full">
        <div class="w-11/12 md:w-3/12 px-4 py-6 mx-auto mt-12 bg-white border rounded">
            @error('email', 'password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <x-form class="space-y-4" method="POST" action="{{ route('login') }}">
                <x-title title="Login" subtitle="Login to the admin console"></x-title>
                <x-input type="email" name="email" placeholder="Enter email"></x-input>
                <x-input type="password" name="password" placeholder="Enter password"></x-input>
                <x-button.primary>Login</x-button.primary>
            </x-form>
        </div>
    </div>
</x-guest-layout>

