@extends('layouts.master')
@section('title', 'Admin Console (Super Admin)')

@section('content')
    <div class="row">
        <div class="col-12 text-center py-5">
            <i class="fas fa-cogs fa-4x text-muted mb-3"></i>
            <h3>System Administration</h3>
            <p class="text-muted">Area konfigurasi teknis & manajemen user.</p>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h6>Total User</h6>
                <h3>{{ $data['total_users'] }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Total Pegawai Terdaftar</h6>
                <h3>{{ $data['total_pegawai'] }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>OPD Aktif</h6>
                <h3>{{ $data['total_opd'] }}</h3>
            </div>
        </div>
    </div>
@endsection