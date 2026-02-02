@extends('layouts.master')
@section('title', 'Dashboard Pegawai')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card p-4 h-100 border-0 shadow-sm">
                <h6 class="text-muted text-uppercase small ls-1">Status Verifikasi</h6>
                @php
                    $statusMap = [
                        'draft' => ['Draft', 'secondary', 'fas fa-pen'],
                        'submitted' => ['Menunggu Verifikasi OPD', 'info', 'fas fa-clock'],
                        'revision_required_opd' => ['Revisi (Dari OPD)', 'warning', 'fas fa-exclamation-triangle'],
                        'approved_opd' => ['Lolos OPD (Menunggu BKD)', 'primary', 'fas fa-check'],
                        'revision_required_bkd' => ['Revisi (Dari BKD)', 'warning', 'fas fa-exclamation-circle'],
                        'final_approved' => ['Valid Final', 'success', 'fas fa-check-double'],
                        'final_rejected' => ['Ditolak Permanen', 'danger', 'fas fa-times-circle']
                    ];
                    [$label, $color, $icon] = $statusMap[$data['status']] ?? ['Unknown', 'dark', 'fas fa-question'];
                @endphp
                <div class="mt-2 text-{{ $color }}">
                    <i class="{{ $icon }} fa-3x mb-3"></i>
                    <h4 class="fw-bold">{{ $label }}</h4>
                </div>

                @if(str_contains($data['status'], 'revision'))
                    <div class="alert alert-warning mt-3">
                        <small><b>Catatan Revisi:</b><br>{{ $data['catatan'] }}</small>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100 border-0 shadow-sm">
                <h6 class="text-muted text-uppercase small ls-1">Dokumen Anda</h6>
                <div class="mt-2">
                    <h1 class="display-4 fw-bold text-primary">{{ $data['uploaded'] }}</h1>
                    <span class="text-muted">Dokumen telah diupload</span>
                </div>
                <hr>
                <a href="{{ route('dokumen.index') }}" class="btn btn-primary d-block">
                    <i class="fas fa-folder-open me-2"></i> Kelola Dokumen
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 h-100 bg-light border-0">
                <h6 class="text-muted text-uppercase small ls-1">Timeline</h6>
                <ul class="list-unstyled mt-3 small">
                    <li class="mb-2 {{ in_array($data['status'], ['draft']) ? 'fw-bold text-primary' : 'text-muted' }}">1.
                        Upload & Submit</li>
                    <li
                        class="mb-2 {{ in_array($data['status'], ['submitted', 'revision_required_opd', 'approved_opd']) ? 'fw-bold text-primary' : 'text-muted' }}">
                        2. Verifikasi OPD</li>
                    <li
                        class="mb-2 {{ in_array($data['status'], ['approved_opd', 'revision_required_bkd', 'final_approved']) ? 'fw-bold text-primary' : 'text-muted' }}">
                        3. Validasi BKD</li>
                    <li
                        class="mb-2 {{ in_array($data['status'], ['final_approved']) ? 'fw-bold text-succcess' : 'text-muted' }}">
                        4. Selesai</li>
                </ul>
            </div>
        </div>
    </div>
@endsection