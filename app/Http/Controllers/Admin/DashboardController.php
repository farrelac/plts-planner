<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstallationRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard admin dengan statistik dan request terbaru.
     */
    public function dashboard()
    {
        // 1. Ambil 5 permintaan terbaru (sudah ada)
        $latestRequests = InstallationRequest::with('user')->latest()->take(5)->get();

        // =======================================================
        //     PENAMBAHAN: Logika untuk menghitung statistik
        // =======================================================
        $totalRequests = InstallationRequest::count();
        $completedRequests = InstallationRequest::where('status', 'Completed')->count();
        $pendingRequests = InstallationRequest::where('status', 'Pending')->count();
        $processedRequests = InstallationRequest::where('status', 'Processed')->count();
        // =======================================================

        // 3. Kirim SEMUA data yang dibutuhkan ke view
        return view('admin.dashboard', compact(
            'latestRequests',
            'totalRequests',
            'completedRequests',
            'pendingRequests',
            'processedRequests'
        ));
    }

    /**
     * Menampilkan daftar semua permintaan (method ini tidak diubah).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchDate = $request->input('search_date');
        
        $query = InstallationRequest::with('user')->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($searchDate) {
            $query->whereDate('created_at', $searchDate);
        }

        $allRequests = $query->paginate(10)->withQueryString();

        return view('admin.requests.index', compact('allRequests'));
    }

    /**
     * Menampilkan form untuk mengedit permintaan (method ini tidak diubah).
     */
    public function edit(InstallationRequest $request)
    {
        return view('admin.requests.edit', compact('request'));
    }

    /**
     * Memperbarui permintaan instalasi (method ini tidak diubah).
     */
    public function update(Request $requestData, InstallationRequest $request)
    {
        $requestData->merge([
            'yearly_psh' => str_replace(',', '.', $requestData->yearly_psh),
        ]);

        $validated = $requestData->validate([
            'yearly_psh' => 'required|numeric|min:1|max:8',
            'status' => 'required|string|in:Pending,Processed,Completed',
            'admin_notes' => 'nullable|string',
        ]);

        $daily_need_wh = $request->daily_energy_wh;
        $psh = $validated['yearly_psh'];
        $system_efficiency = 0.75;

        $recommended_wp = $daily_need_wh / ($psh * $system_efficiency);

        $request->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'recommended_panel_wp' => round($recommended_wp),
        ]);

        return redirect()->route('admin.requests.index')->with('success', 'Permintaan berhasil diperbarui!');
    }
    
    /**
     * Menampilkan detail lengkap dari sebuah permintaan (method ini tidak diubah).
     */
    public function show(InstallationRequest $request)
    {
        return view('admin.requests.show', compact('request'));
    }

    /**
     * Menghapus data permintaan dari database (method ini tidak diubah).
     */
    public function destroy(InstallationRequest $request)
    {
        if ($request->status !== 'Completed') {
            return back()->with('error', 'Hanya permintaan dengan status "Completed" yang dapat dihapus.');
        }

        $request->delete();

        return redirect()->route('admin.requests.index')->with('success', 'Data permintaan berhasil dihapus.');
    }
}