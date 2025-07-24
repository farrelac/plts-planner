{{-- Menggunakan layout utama Anda 'app.blade.php' --}}
@extends('layouts.app')

{{-- Menyuntikkan konten ke dalam @yield('content') di layout utama --}}
@section('content')
    
    {{-- Anda bisa menambahkan judul di sini jika diinginkan --}}
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h1>

    <div class="space-y-6">
        {{-- Kotak untuk update informasi profil --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Kotak untuk update password --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Kotak untuk hapus akun --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

@endsection