@extends('layouts.master')
@section('title', 'Detail Verifikasi: ' . $pegawai->nama_lengkap)

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="fw-bold">Data Pegawai</h6>
                    <p class="mb-1"><strong>Nama:</strong> {{ $pegawai->nama_lengkap }}</p>
                    <p class="mb-1"><strong>NIP:</strong> {{ $pegawai->nip ?? '-' }}</p>
                    <hr>
                    <form action="{{ route('verifikasi.approve', $pegawai->id) }}" method="POST" class="d-grid gap-2 mb-2">
                        @csrf
                        <button class="btn btn-success"><i class="fas fa-check"></i> Setujui Berkas</button>
                    </form>
                    <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal"><i
                            class="fas fa-times"></i> Tolak / Revisi</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="m-0">Berkas Uploaded</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @foreach($pegawai->uploads as $upload)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $upload->dokumen->nama }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $upload->original_name }}</small>
                                </div>
                                <a href="{{ Storage::url($upload->file_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div class="modal fade" id="rejectModal">
        <div class="modal-dialog">
            <form action="{{ route('verifikasi.reject', $pegawai->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Catatan Perbaikan</h5>
                    </div>
                    <div class="modal-body">
                        <textarea name="catatan" class="form-control" rows="4"
                            placeholder="Jelaskan apa yang perlu diperbaiki..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger">Kirim Penolakan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection