@extends('layouts.master')
@section('title', 'Upload Dokumen Persyaratan')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="m-0 fw-bold">Daftar Dokumen</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">Dokumen</th>
                                <th scope="col">Wajib</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokumens as $doc)
                                @php
                                    $upload = $uploads[$doc->id] ?? null;
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold d-block">{{ $doc->nama }}</span>
                                        @if($upload)
                                            <small class="text-muted">{{ $upload->original_name }}
                                                ({{ number_format($upload->size_kb) }} KB)</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($doc->is_required)
                                            <span class="badge bg-danger">Wajib</span>
                                        @else
                                            <span class="badge bg-secondary">Opsional</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($upload)
                                            @if($upload->status == 'valid')
                                                <span class="badge bg-success"><i class="fas fa-check"></i> Valid</span>
                                            @elseif($upload->status == 'invalid')
                                                <span class="badge bg-danger"><i class="fas fa-times"></i> Ditolak</span>
                                            @else
                                                <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Pending</span>
                                            @endif
                                        @else
                                            <span class="badge bg-light text-muted border">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#uploadModal"
                                            onclick="setUpload('{{ $doc->id }}', '{{ $doc->nama }}')">
                                            <i class="fas fa-upload"></i> {{ $upload ? 'Update' : 'Upload' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

                <div class="card-body">
                    <h5>Petunjuk</h5>
                    <ul class="small mb-0 ps-3">
                        <li>Format file yang didukung: PDF, JPG, PNG.</li>
                        <li>Maksimal ukuran file: 10MB.</li>
                        <li>Pastikan dokumen terbaca dengan jelas.</li>
                        <li>Jika ditolak, segera perbaiki sesuai catatan.</li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h6>Status Saat Ini</h6>
                    @php
                        $statusMap = [
                            'draft' => ['Draft', 'secondary'],
                            'submitted' => ['Sudah Disubmit', 'info'],
                            'revision_required_opd' => ['Revisi (OPD)', 'warning'],
                            'approved_opd' => ['Disetujui OPD', 'primary'],
                            'revision_required_bkd' => ['Revisi (BKD)', 'warning'],
                            'final_approved' => ['Valid (Final)', 'success'],
                            'final_rejected' => ['Ditolak Permanen', 'danger']
                        ];
                        [$label, $color] = $statusMap[$pegawai->status_verval] ?? ['Unknown', 'dark'];
                    @endphp
                    <div class="alert alert-{{ $color }} text-center fw-bold mb-3">
                        {{ strtoupper($label) }}
                    </div>

                    @if($pegawai->status_verval == 'draft' || $pegawai->status_verval == 'revision_required_opd' || $pegawai->status_verval == 'revision_required_bkd')
                        <form action="{{ route('dokumen.submit') }}" method="POST">
                            @csrf
                            <button class="btn btn-success w-100 py-2 fw-bold" onclick="return confirm('Apakah Anda yakin semua dokumen sudah benar? Data akan dikunci setelah submit.')">
                                <i class="fas fa-paper-plane me-2"></i> SUBMIT DOKUMEN
                            </button>
                        </form>
                    @else
                        <div class="alert alert-light border text-center text-muted small">
                            <i class="fas fa-lock me-1"></i> Data sedang dalam proses verifikasi/validasi. Tidak dapat diubah.
                        </div>
                    @endif
                </div>
            </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload <span id="modalDocName"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="dokumen_id" id="modalDocId">
                        <div class="mb-3">
                            <label class="form-label">Pilih File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function setUpload(id, name) {
            document.getElementById('modalDocId').value = id;
            document.getElementById('modalDocName').innerText = name;
        }
    </script>
@endsection