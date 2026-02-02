@extends('layouts.master')
@section('title', 'Dashboard Validasi BKD')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4 border-start border-4 border-primary">
                <h5>Siap Validasi</h5>
                <p class="text-muted">Berkas lolos dari OPD</p>
                <h2 class="fw-bold">{{ $data['total_opd_approved'] }}</h2>
                <a href="{{ route('validasi.index') }}" class="btn btn-sm btn-outline-primary mt-2">Mulai Validasi</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4 border-start border-4 border-success">
                <h5>Final Approved</h5>
                <p class="text-muted">Berkas selesai diproses</p>
                <h2 class="fw-bold">{{ $data['total_final'] }}</h2>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="m-0 fw-bold">Menunggu Atensi Anda</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-middle user-select-none">
                <thead>
                    <tr>
                        <th class="ps-4">Nama Pegawai</th>
                        <th>NIP</th>
                        <th>Waktu Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['recent_approved'] as $p)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->nip ?? '-' }}</td>
                            <td>{{ $p->updated_at->format('d M Y') }}</td>
                            <td><span class="badge bg-primary">Approved by OPD</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Semua validasi terselesaikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection