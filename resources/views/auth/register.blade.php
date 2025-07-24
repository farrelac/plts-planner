<x-guest-layout>
    <div x-data="{ isLoading: false }">
        {{-- MODAL LOADING --}}
        <div x-show="isLoading" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="flex items-center gap-4 bg-white p-6 rounded-lg shadow-xl">
                <svg class="animate-spin h-8 w-8 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-semibold text-gray-700">Creating your account...</span>
            </div>
        </div>
        
        <h2 class="text-3xl font-bold text-gray-800">Buat Akun Baru</h2>
        <p class="mt-2 text-gray-500">Silakan lengkapi data di bawah ini.</p>

        <form method="POST" action="{{ route('register') }}" @submit="isLoading = true" class="mt-8">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                {{-- Komponen ini sekarang akan menggunakan style yang sudah diperbaiki --}}
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                              class="mt-1 block w-full px-4 py-3"
                              placeholder="Masukkan nama lengkap"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                              class="mt-1 block w-full px-4 py-3"
                              placeholder="Masukkan alamat email"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                              class="mt-1 block w-full px-4 py-3"
                              placeholder="Buat password baru"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                 <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                 <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="mt-1 block w-full px-4 py-3"
                               placeholder="Ulangi password baru"/>
                 <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                    Register
                </button>
            </div>
            
            <div class="text-center mt-6">
                 <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a class="font-semibold text-sky-600 hover:text-sky-500" href="{{ route('login') }}">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>