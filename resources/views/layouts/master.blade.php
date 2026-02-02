<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Verval Pegawai') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Nunito', sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: #1e293b;
            color: #fff;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 10px 20px;
            font-size: 1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #3b82f6;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .header {
            background: #fff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div id="app" class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3" style="width: 250px;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4 fw-bold"><i class="fas fa-file-shield me-2"></i>VerVal</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                @role('Pegawai')
                <li>
                    <a href="{{ route('dokumen.index') }}"
                        class="nav-link {{ request()->is('dokumen*') ? 'active' : '' }}">
                        <i class="fas fa-file-upload me-2"></i> Upload Berkas
                    </a>
                </li>
                @endrole
                @role('Admin OPD|Super Admin')
                <li>
                    <a href="{{ route('verifikasi.index') }}"
                        class="nav-link {{ request()->is('verifikasi*') ? 'active' : '' }}">
                        <i class="fas fa-check-double me-2"></i> Verifikasi
                    </a>
                </li>
                @endrole
                <li>
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-line me-2"></i> Laporan
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=random"
                        alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>{{ Auth::user()->name ?? 'Guest' }}</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Sign out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1" style="max-height: 100vh; overflow-y: auto;">
            <header class="header py-3 px-4 d-flex justify-content-between align-items-center sticky-top">
                <h5 class="m-0 text-muted">@yield('title', 'Dashboard')</h5>
                <span
                    class="badge bg-primary rounded-pill">{{ Auth::user()->getRoleNames()->first() ?? 'Guest' }}</span>
            </header>

            <main class="py-4 px-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>