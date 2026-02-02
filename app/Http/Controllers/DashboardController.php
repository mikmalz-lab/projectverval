<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pegawai;
use App\Models\DokumenUpload;
use App\Models\Opd;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user)
            return redirect('/login');

        if ($user->hasRole('Pegawai')) {
            return redirect()->route('dashboard.pegawai');
        } elseif ($user->hasRole('Admin OPD')) {
            return redirect()->route('dashboard.opd');
        } elseif ($user->hasRole(['Admin BKD', 'BKN'])) {
            return redirect()->route('dashboard.bkd');
        } elseif ($user->hasRole('Super Admin')) {
            return redirect()->route('dashboard.admin');
        }

        return abort(403, 'Role not assigned properly.');
    }

    public function pegawai()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;
        $data = [
            'status' => $pegawai ? $pegawai->status_verval : 'draft',
            'uploaded' => $pegawai ? $pegawai->uploads->count() : 0,
            'catatan' => $pegawai ? $pegawai->catatan_final : '-'
        ];
        return view('dashboard.pegawai', compact('data'));
    }

    public function opd()
    {
        $user = Auth::user();
        // Assuming Admin OPD is linked to an OPD. For prototype, we show all submission for now or mock data
        $data = [
            'total_masuk' => Pegawai::whereIn('status_verval', ['submitted', 'revision_required_opd'])->count(),
            'total_approved' => Pegawai::where('status_verval', 'approved_opd')->count(),
            'total_revisi' => Pegawai::where('status_verval', 'revision_required_opd')->count(),
            'recent' => Pegawai::where('status_verval', 'submitted')->latest()->take(5)->get()
        ];
        return view('dashboard.opd', compact('data'));
    }

    public function bkd()
    {
        // Shared logic with BKN (View Only handled in blade)
        $data = [
            'total_opd_approved' => Pegawai::where('status_verval', 'approved_opd')->count(),
            'total_final' => Pegawai::where('status_verval', 'final_approved')->count(),
            'recent_approved' => Pegawai::where('status_verval', 'approved_opd')->latest()->take(5)->get()
        ];
        return view('dashboard.bkd', compact('data'));
    }

    public function admin()
    {
        $data = [
            'total_users' => \App\Models\User::count(),
            'total_pegawai' => Pegawai::count(),
            'total_opd' => Opd::count(),
        ];
        return view('dashboard.admin', compact('data'));
    }
}
