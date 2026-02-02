<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\DokumenUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;

        // Auto-create pegawai profile if not exists for prototype ease
        if (!$pegawai) {
            $pegawai = \App\Models\Pegawai::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name
            ]);
        }

        $dokumens = Dokumen::all();
        $uploads = $pegawai->uploads->keyBy('dokumen_id');

        return view('dokumen.index', compact('dokumens', 'uploads', 'pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokumen_id' => 'required|exists:dokumens,id',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB
        ]);

        $pegawai = Auth::user()->pegawai;
        $file = $request->file('file');
        // Ensure directory exists
        $path = $file->store('dokumen_pegawai/' . $pegawai->id, 'public');

        DokumenUpload::updateOrCreate(
            [
                'pegawai_id' => $pegawai->id,
                'dokumen_id' => $request->dokumen_id
            ],
            [
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size_kb' => $file->getSize() / 1024,
                'status' => 'pending',
                'version' => 1
            ]
        );

        // $pegawai->update(['status_verval' => 'menunggu_verifikasi']); // Disable auto-submit

        return back()->with('success', 'Dokumen berhasil diupload. Silakan lanjutkan upload atau klik Submit jika sudah selesai.');
    }

    public function submit()
    {
        $pegawai = Auth::user()->pegawai;

        // Basic check: Ensure at least one file uploaded (or stricter check later)
        if ($pegawai->uploads->count() == 0) {
            return back()->with('error', 'Harap upload minimal satu dokumen sebelum submit.');
        }

        $pegawai->update(['status_verval' => 'submitted']);

        return back()->with('success', 'Berkas berhasil disubmit ke Admin OPD.');
    }
}
