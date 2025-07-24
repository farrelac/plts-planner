<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form id="password-update-form" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        
        {{-- ... (input fields remain the same) ... --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
        </div>
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        </div>
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button
                type="button"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-password-update')"
            >{{ __('Save') }}</x-primary-button>

             @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <x-modal name="confirm-password-update" :show="false" focusable>
        <div class="p-6 bg-white"> {{-- Memastikan background modal putih --}}
            <h2 class="text-lg font-medium text-gray-900">
                Konfirmasi Perubahan Password
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Apakah Anda yakin ingin menyimpan password baru ini?
            </p>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3" onclick="document.getElementById('password-update-form').submit();">
                    {{ __('Save Password') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</section>