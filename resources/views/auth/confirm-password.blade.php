<x-guest-layout>
    <h2 class="text-3xl font-bold text-gray-800">Konfirmasi Password</h2>
    <p class="mt-2 text-gray-500">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-8">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500"
                   placeholder="Masukkan password Anda">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>