@extends('layouts.master')
@section('title', 'Verifikasi Berkas Pegawai')

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama Pegawai</th>
                        <th>NIP</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawais as $p)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->nip ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge bg-warning text-dark">{{ strtoupper(str_replace('_', ' ', $p->status_verval)) }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('verifikasi.show', $p->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-search"></i> Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada berkas masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection