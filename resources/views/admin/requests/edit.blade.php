@extends('layouts.app')

@section('header_title', 'Proses Permintaan #' . $request->id)

@section('content')
    {{-- Inisialisasi Alpine.js untuk mengelola state loading --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" x-data="{ isLoading: false }">

        {{-- Pop-up Loading --}}
        <div x-show="isLoading" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <div class="flex items-center gap-4 bg-white p-6 rounded-lg shadow-xl">
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-semibold text-gray-700">Menyimpan data, mohon tunggu...</span>
            </div>
        </div>

        <!-- Kolom Detail Permintaan -->
        <div class="md:col-span-1 card">
            <h3 class="text-lg font-bold text-gray-800">Detail Permintaan</h3>
            <p class="text-sm text-gray-500 mb-6">Informasi dari pelanggan.</p>
            <div class="space-y-3 text-sm">
                <div><p class="font-bold text-gray-800">Nama:</p><p>{{ $request->customer_name }}</p></div>
                <div><p class="font-bold text-gray-800">Alamat:</p><p>{{ $request->customer_address }}</p></div>
                <div><p class="font-bold text-gray-800">Telepon:</p><p>{{ $request->customer_phone }}</p></div>
                <div><p class="font-bold text-gray-800">Kota:</p><p>{{ $request->city }}</p></div>
                <div class="pt-2">
                    <p class="font-bold text-gray-800 text-base">Kebutuhan Energi:</p>
                    <p class="text-xl font-bold text-blue-600">{{ number_format($request->daily_energy_wh) }} Wh/hari</p>
                </div>
            </div>
        </div>

        <!-- Kolom Form Admin -->
        <div class="md:col-span-2 card">
            {{-- Tambahkan @submit untuk memicu state isLoading --}}
            <form action="{{ route('admin.requests.update', $request->id) }}" method="POST" @submit="isLoading = true">
                @csrf
                @method('PUT')
                <h3 class="text-lg font-bold text-gray-800">Form Prediksi & Update</h3>
                <p class="text-sm text-gray-500 mb-6">Hitung rekomendasi dan ubah status permintaan.</p>
                
                <div class="space-y-5">
                    <div>
                        <label for="yearly_psh" class="block text-sm font-medium text-gray-700 mb-1">Peak Sun Hour (PSH) Tahunan</label>
                        <input type="text" name="yearly_psh" id="yearly_psh" value="{{ old('yearly_psh', '4,5') }}" class="mt-1 w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        @error('yearly_psh') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Permintaan</label>
                        <select id="status" name="status" class="mt-1 block w-full p-3 border border-gray-300 bg-white rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="Pending" @if($request->status == 'Pending') selected @endif>Pending</option>
                            <option value="Processed" @if($request->status == 'Processed') selected @endif>Processed</option>
                            <option value="Completed" @if($request->status == 'Completed') selected @endif>Completed</option>
                        </select>
                    </div>

                    <div>
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin</label>
                        <textarea id="admin_notes" name="admin_notes" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('admin_notes', $request->admin_notes) }}</textarea>
                    </div>

                    @if($request->recommended_panel_wp)
                        <div class="bg-blue-50 p-3 rounded-md">
                            <p class="text-sm font-medium text-blue-800">Rekomendasi Tersimpan: <span class="font-bold text-blue-900">{{ number_format($request->recommended_panel_wp) }} Wp</span></p>
                        </div>
                    @endif

                    <div class="text-right pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-all">Simpan & Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection