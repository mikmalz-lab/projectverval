@extends('layouts.master')
@section('title', 'Dashboard Admin OPD')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3">
                <small class="text-muted">Antrian Verifikasi</small>
                <h3 class="fw-bold text-info">{{ $data['total_masuk'] }}</h3>
                <a href="{{ route('verifikasi.index') }}" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3">
                <small class="text-muted">Disetujui</small>
                <h3 class="fw-bold text-success">{{ $data['total_approved'] }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 p-3">
                <small class="text-muted">Perlu Revisi</small>
                <h3 class="fw-bold text-warning">{{ $data['total_revisi'] }}</h3>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="m-0 fw-bold">Pengajuan Terbaru (Perlu Verifikasi)</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Tanggal Submit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['recent'] as $p)
                        <tr>
                            <td class="ps-4">{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->updated_at->diffForHumans() }}</td>
                            <td><a href="{{ route('verifikasi.show', $p->id) }}" class="btn btn-sm btn-primary">Periksa</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Tidak ada pengajuan baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection