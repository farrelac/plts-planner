<x-guest-layout>
    <div x-data="{ isLoading: false }">
        {{-- MODAL LOADING --}}
        <div x-show="isLoading" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="flex items-center gap-4 bg-white p-6 rounded-lg shadow-xl">
                <svg class="animate-spin h-8 w-8 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-semibold text-gray-700">Logging in...</span>
            </div>
        </div>

        {{-- Judul Form --}}
        <h2 class="text-3xl font-bold text-gray-800">Selamat Datang</h2>
        <p class="mt-2 text-gray-500">Masuk dengan email dan password Anda.</p>

        {{-- Form Login --}}
        <form method="POST" action="{{ route('login') }}" @submit="isLoading = true" class="mt-8">
            @csrf

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Email Address (diganti labelnya jadi Username) -->
            <div>
                <label for="email" class="text-sm font-medium text-gray-700">Username</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                       placeholder="Masukkan username">
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                       placeholder="Masukkan password">
            </div>

            <!-- Forgot your password? -->
             @if (Route::has('password.request'))
                <div class="text-right mt-4">
                    <a class="text-sm font-medium text-sky-600 hover:text-sky-500" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                </div>
            @endif

            <!-- Tombol Log In -->
            <div class="mt-6">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                    Log In
                </button>
            </div>

            <!-- Link Register -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a class="font-semibold text-sky-600 hover:text-sky-500" href="{{ route('register') }}">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>