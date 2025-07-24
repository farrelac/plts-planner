<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="profile-update-form" method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- ... (input fields remain the same) ... --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
        </div>
        
        <div class="flex items-center gap-4">
            <x-primary-button
                type="button"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-profile-information-update')"
            >{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <x-modal name="confirm-profile-information-update" :show="false" focusable>
        <div class="p-6 bg-white"> {{-- Memastikan background modal putih --}}
            <h2 class="text-lg font-medium text-gray-900">
                Konfirmasi Perubahan Profil
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Apakah Anda yakin ingin menyimpan perubahan ini?
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3" onclick="document.getElementById('profile-update-form').submit();">
                    {{ __('Save Changes') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</section>