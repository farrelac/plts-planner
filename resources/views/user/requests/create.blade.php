@extends('layouts.app')

@section('header_title', 'Formulir Permintaan Pemasangan PLTS')

@section('content')
    {{-- 1. Tambahkan x-data untuk mengelola status loading --}}
    <div class="max-w-2xl mx-auto" x-data="{ isLoading: false }">

        {{-- MODAL LOADING BARU --}}
        <div x-show="isLoading" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="flex items-center gap-4 bg-white p-6 rounded-lg shadow-xl">
                {{-- Spinner --}}
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-semibold text-gray-700">Mengirim pengajuan, mohon tunggu...</span>
            </div>
        </div>
        
        <div class="card">
            <p class="text-gray-600 mb-6">Lengkapi data di bawah ini untuk mengajukan permintaan pemasangan. Tim kami akan menghubungi Anda untuk tahap selanjutnya.</p>

            {{-- 2. Tambahkan @submit pada form untuk menampilkan pop-up --}}
            <form action="{{ route('request.store') }}" method="POST" @submit="isLoading = true">
                @csrf
                <div class="space-y-4">
                    <div>
                        <x-input-label for="customer_name" :value="__('Nama Lengkap Sesuai KTP')" />
                        <x-text-input id="customer_name" class="block mt-1 w-full" type="text" name="customer_name" :value="old('customer_name', auth()->user()->name)" required autofocus />
                        <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="customer_address" :value="__('Alamat Lengkap Pemasangan')" />
                        <textarea name="customer_address" id="customer_address" rows="3" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('customer_address') }}</textarea>
                        <x-input-error :messages="$errors->get('customer_address')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="customer_phone" :value="__('Nomor Telepon (WhatsApp Aktif)')" />
                        <x-text-input id="customer_phone" class="block mt-1 w-full" type="tel" name="customer_phone" :value="old('customer_phone')" required />
                        <x-input-error :messages="$errors->get('customer_phone')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="city" :value="__('Kota/Kabupaten')" />
                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required placeholder="Contoh: Jakarta Selatan" />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="daily_energy_wh" :value="__('Perkiraan Kebutuhan Energi Harian (Wh)')" />
                        <x-text-input id="daily_energy_wh" class="block mt-1 w-full" type="number" name="daily_energy_wh" :value="old('daily_energy_wh')" required placeholder="Lihat dari tagihan listrik bulanan Anda" />
                        <x-input-error :messages="$errors->get('daily_energy_wh')" class="mt-2" />
                    </div>
                    <div class="flex items-center gap-4 pt-4">
                        <a href="{{ route('dashboard') }}" class="w-1/3 text-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Batal
                        </a>
                        {{-- 3. Tombol ini tidak perlu diubah, biarkan menjadi submit biasa --}}
                        <x-primary-button class="w-2/3 justify-center">
                            {{ __('Kirim Pengajuan') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection