@extends('layouts.master')
@section('title', 'Validasi Akhir (BKN/BKD)')

@section('content')
    <div class="card">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold">Antrian Validasi (Approved by OPD)</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama Pegawai</th>
                        <th>NIP</th>
                        <th>Status OPD</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawais as $p)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->nip ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary">APPROVED OPD</span>
                                @if($p->status_verval == 'revision_required_bkd')
                                    <span class="badge bg-warning text-dark">Dikembalikan BKD (Revisi)</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#validasiModal{{ $p->id }}">
                                    <i class="fas fa-gavel"></i> Validasi
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Validasi per Pegawai -->
                        <div class="modal fade" id="validasiModal{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Validasi Final: {{ $p->nama_lengkap }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h6>Berkas Uploaded</h6>
                                                <ul class="list-group">
                                                    @foreach($p->uploads as $upload)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong>{{ $upload->dokumen->nama }}</strong>
                                                                <br><small class="text-muted">{{ $upload->original_name }}</small>
                                                            </div>
                                                            <a href="{{ Storage::url($upload->file_path) }}" target="_blank"
                                                                class="btn btn-sm btn-outline-info">Lihat</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-md-5 border-start">
                                                <h6 class="fw-bold text-success">Keputusan Validator</h6>
                                                <hr>
                                                <form action="{{ route('validasi.approve', $p->id) }}" method="POST"
                                                    class="mb-3">
                                                    @csrf
                                                    <p class="small text-muted">Jika seluruh berkas valid & sesuai persyaratan.
                                                    </p>
                                                    <button class="btn btn-success w-100 fw-bold"><i
                                                            class="fas fa-check-double"></i> APPROVE FINAL</button>
                                                </form>

                                                <hr>
                                                <h6 class="fw-bold text-danger">Tolak / Revisi</h6>
                                                <form action="{{ route('validasi.reject', $p->id) }}" method="POST">
                                                    @csrf
                                                    <div class="mb-2">
                                                        <textarea name="catatan" class="form-control"
                                                            placeholder="Tulis catatan penolakan untuk Pegawai & OPD..."
                                                            required></textarea>
                                                    </div>
                                                    <button class="btn btn-danger w-100"><i class="fas fa-times"></i> TOLAK
                                                        (REVISI)</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Tidak ada berkas siap validasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection