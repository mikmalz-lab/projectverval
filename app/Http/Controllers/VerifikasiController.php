<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\DokumenUpload;

class VerifikasiController extends Controller
{
    public function index()
    {
        // OPD sees submitted docs or those resubmitted (status stays submitted when resubmitted usually, but let's assume user flow resets to submitted)
        $pegawais = Pegawai::whereIn('status_verval', ['submitted', 'revision_required_opd'])->with('uploads')->get();
        return view('verifikasi.index', compact('pegawais'));
    }

    public function show($id)
    {
        $pegawai = Pegawai::with('uploads.dokumen')->findOrFail($id);
        return view('verifikasi.show', compact('pegawai'));
    }

    public function approve(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // Ensure state
        if (!in_array($pegawai->status_verval, ['submitted', 'revision_required_opd'])) {
            return back()->with('error', 'Status berkas tidak valid untuk verifikasi.');
        }

        $pegawai->update(['status_verval' => 'approved_opd']);
        return redirect()->route('verifikasi.index')->with('success', 'Berkas disetujui, lanjut ke BKD/Validasi.');
    }

    public function reject(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update([
            'status_verval' => 'revision_required_opd',
            'catatan_final' => $request->catatan
        ]);
        return redirect()->route('verifikasi.index')->with('success', 'Berkas dikembalikan ke pegawai (Revisi OPD).');
    }
}
