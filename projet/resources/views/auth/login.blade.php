<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" class="rajae">
            @csrf

            <!-- Email Address -->
            <div class="email">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <div>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    </div>
                </label>
            </div>
            
            <div class="mt-4" style="display: flex; align-items: center; gap: 2%;">
                    <x-button class="ml-3">
                    {{ __('Login') }}
                    </x-button>
                    
                    <x-button class="ml-3">
                    <a href="/register" style="text-decoration: none;">register</a>
                    </x-button>
            </div>
            
        </form>
    </x-auth-card>
</x-guest-layout>
