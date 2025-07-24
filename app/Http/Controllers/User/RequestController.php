<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InstallationRequest; // Model sudah di-import
use Carbon\Carbon;

class RequestController extends Controller
{
    /**
     * Menampilkan halaman/form untuk membuat permintaan baru.
     */
    public function create()
    {
        return view('user.requests.create');
    }

    /**
     * Menyimpan permintaan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi semua input dari form (Sudah Benar)
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'customer_phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'daily_energy_wh' => 'required|integer|min:1',
        ]);

        // PERBAIKAN: Menambahkan status 'Pending' secara eksplisit saat membuat data.
        $validatedData['status'] = 'Pending';
        
        // Buat entri baru yang terhubung dengan user yang sedang login
        Auth::user()->installationRequests()->create($validatedData);

        // ===============================================
        //    PENAMBAHAN: Arahkan ke Halaman Riwayat 
        // ===============================================
        // Ini adalah perubahan utama agar notifikasi sukses muncul di halaman riwayat.
        return redirect()->route('requests.history')
                         ->with('success', 'Pengajuan Anda telah berhasil dikirim! Tim kami akan segera menindaklanjuti.');
    }

    /**
     * Menampilkan halaman riwayat permintaan milik pengguna.
     */
    public function history(Request $request)
    {
        // Kode ini sudah sangat baik dan tidak perlu diubah.
        $search = $request->input('search');
        $searchDate = $request->input('search_date');
        
        $query = Auth::user()->installationRequests()->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($searchDate) {
            $query->whereDate('created_at', $searchDate);
        }

        $myRequests = $query->paginate(10)->withQueryString();

        return view('user.requests.history', compact('myRequests'));
    }

    /**
     * Menampilkan form untuk mengedit permintaan.
     */
    public function edit(InstallationRequest $request)
    {
        // Kode otorisasi sudah benar.
        if ($request->user_id !== Auth::id() || $request->status !== 'Pending') {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        return view('user.requests.edit', compact('request'));
    }

    /**
     * Memperbarui permintaan yang ada di database.
     */
    public function update(Request $requestData, InstallationRequest $request)
    {
        // Kode otorisasi sudah benar.
        if ($request->user_id !== Auth::id() || $request->status !== 'Pending') {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        $validatedData = $requestData->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'customer_phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'daily_energy_wh' => 'required|integer|min:1',
        ]);

        $request->update($validatedData);

        // Pesan sukses sudah ada dan benar.
        return redirect()->route('requests.history')->with('success', 'Permintaan Anda berhasil diperbarui!');
    }

    /**
     * Menampilkan detail permintaan.
     */
    public function show(InstallationRequest $request)
    {
        // Kode otorisasi sudah benar.
        if ($request->user_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        return view('user.requests.show', compact('request'));
    }

    /**
     * Menghapus (membatalkan) permintaan.
     */
    public function destroy(InstallationRequest $request)
    {
        // Kode otorisasi sudah benar.
        if ($request->user_id !== Auth::id() || $request->status !== 'Pending') {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        $request->delete();

        // Pesan sukses sudah ada dan benar.
        return redirect()->route('requests.history')->with('success', 'Permintaan Anda telah berhasil dibatalkan.');
    }
}