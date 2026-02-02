<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class ValidasiController extends Controller
{
    // BKD Scope
    public function index()
    {
        // BKD only sees docs that have been approved by OPD
        $pegawais = Pegawai::where('status_verval', 'approved_opd')
            ->orWhere('status_verval', 'revision_required_bkd') // If want to track rejections
            ->with('uploads')
            ->get();
        return view('validasi.index', compact('pegawais'));
    }

    public function approve(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->status_verval != 'approved_opd' && $pegawai->status_verval != 'revision_required_bkd') {
            return back()->with('error', 'Status tidak valid untuk validasi akhir.');
        }

        $pegawai->update([
            'status_verval' => 'final_approved',
            'finalized_at' => now()
        ]);

        return redirect()->route('validasi.index')->with('success', 'Pegawai FINAL APPROVED.');
    }

    public function reject(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // If rejected by BKD, user must revise.
        // Status becomes 'revision_required_bkd' or send back to 'revision_required_opd'?
        // Flow says: Status: REVISION_REQUIRED_BKD.

        $pegawai->update([
            'status_verval' => 'revision_required_bkd',
            'catatan_final' => '[BKD] ' . $request->catatan // Tagging rejection note
        ]);

        return redirect()->route('validasi.index')->with('success', 'Berkas ditolak (Revisi BKD).');
    }
}
