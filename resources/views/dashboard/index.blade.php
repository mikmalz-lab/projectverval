@extends('layouts.master')
@section('title', 'Dashboard Overview')

@section('content')
    <div class="row">
        @role('Pegawai')
        <div class="col-md-4">
            <div class="card p-4">
                <h6 class="text-muted">Status Berkas</h6>
                @php
                    $statusColor = match ($data['status'] ?? '') {
                        'valid' => 'success',
                        'ditolak', 'perbaikan' => 'danger',
                        default => 'warning'
                    };
                @endphp
                <h3 class="text-{{ $statusColor }} fw-bold">
                    {{ strtoupper(str_replace('_', ' ', $data['status'] ?? 'Draft')) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4">
                <h6 class="text-muted">Dokumen Diupload</h6>
                <h3>{{ $data['uploaded'] ?? 0 }} File</h3>
            </div>
        </div>
        @endrole

        @role('Admin OPD|Super Admin|Admin BKD')
        <div class="col-md-3">
            <div class="card p-3 border-start border-4 border-primary">
                <h6 class="text-muted">Total Pegawai</h6>
                <h3>{{ $data['total_pegawai'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 border-start border-4 border-warning">
                <h6 class="text-muted">Menunggu Validasi</h6>
                <h3>{{ $data['menunggu_validasi'] ?? 0 }}</h3>
            </div>
        </div>
        @endrole
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Informasi</h6>
                </div>
                <div class="card-body">
                    <p>Selamat datang di Aplikasi Verifikasi dan Validasi Berkas Pegawai.</p>
                    <p>Silakan gunakan menu di sebelah kiri untuk mengelola data.</p>
                    <hr>
                    <small class="text-muted">Login sebagai: {{ Auth::user()->name }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection