<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SIMPEL-SOS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        /* --- GITHUB THEME VARIABLES --- */
        :root {
            --gh-header-bg: #24292f;
            --gh-header-text: #ffffff;
            --gh-bg: #f6f8fa;
            --gh-border: #d0d7de;
            --gh-text-primary: #24292f;
            --gh-text-secondary: #57606a;
            --gh-link: #0969da;
            --gh-btn-primary: #2da44e;
            --gh-btn-hover: #2c974b;
            --sidebar-width: 280px;
        }

        body {
            background-color: var(--gh-bg);
            /* GitHub System Font Stack */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Noto Sans", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            color: var(--gh-text-primary);
            font-size: 14px;
            line-height: 1.5;
        }

        a {
            text-decoration: none;
            color: var(--gh-link);
        }

        a:hover {
            text-decoration: underline;
        }

        /* --- HEADER --- */
        .gh-header {
            background-color: var(--gh-header-bg);
            color: var(--gh-header-text);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .gh-logo {
            color: white;
            font-weight: 600;
            font-size: 20px;
            /* Sedikit diperbesar */
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none !important;
        }

        .gh-logo:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        .header-item {
            color: white;
            font-weight: 600;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 6px;
            transition: 0.2s;
        }

        .header-item:hover {
            background: rgba(255, 255, 255, 0.15);
            text-decoration: none;
        }

        /* --- LAYOUT CONTAINER --- */
        .gh-container {
            display: flex;
            max-width: 1400px;
            /* Membatasi lebar agar tidak terlalu stretch */
            margin: 0 auto;
            padding: 24px;
            gap: 24px;
            align-items: flex-start;
            /* Penting untuk sidebar sticky */
        }

        /* --- SIDEBAR --- */
        .gh-sidebar {
            width: var(--sidebar-width);
            flex-shrink: 0;
            position: sticky;
            top: 90px;
            /* Jarak dari header */
        }

        .menu-heading {
            font-size: 12px;
            font-weight: 600;
            color: var(--gh-text-secondary);
            margin: 24px 0 8px 8px;
            text-transform: uppercase;
        }

        .menu-heading:first-child {
            margin-top: 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            color: var(--gh-text-primary);
            border-radius: 6px;
            margin-bottom: 2px;
            font-size: 14px;
            transition: background 0.1s;
        }

        .nav-item:hover {
            background-color: #eaeef2;
            text-decoration: none;
            color: var(--gh-text-primary);
        }

        .nav-item.active {
            background-color: #eaeef2;
            /* GitHub style active state is subtle or uses border */
            font-weight: 600;
            position: relative;
        }

        /* Garis biru indikator active ala GitHub Settings */
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 6px;
            bottom: 6px;
            width: 4px;
            background-color: #fd8c73;
            /* Atau biru #0969da, oranye sering dipakai di menu */
            border-radius: 6px;
        }

        .nav-item i {
            width: 20px;
            margin-right: 8px;
            color: var(--gh-text-secondary);
            text-align: center;
        }

        .nav-item.active i {
            color: var(--gh-text-primary);
        }

        /* PROFILE BOX DI SIDEBAR */
        .profile-box {
            border-bottom: 1px solid var(--gh-border);
            padding-bottom: 16px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddf4ff;
            /* Light blue */
            color: #0969da;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: 1px solid rgba(27, 31, 36, 0.15);
        }

        /* --- MAIN CONTENT --- */
        .gh-main {
            flex-grow: 1;
            min-width: 0;
            /* Mencegah overflow pada flex item */
        }

        /* Card Style ala GitHub (Box) */
        .gh-box {
            background-color: #ffffff;
            border: 1px solid var(--gh-border);
            border-radius: 6px;
            overflow: hidden;
            /* Agar border radius anak elemen tidak bocor */
        }

        .gh-box-header {
            background-color: #f6f8fa;
            border-bottom: 1px solid var(--gh-border);
            padding: 16px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .gh-box-body {
            padding: 20px;
        }

        /* Overriding Bootstrap Buttons to GitHub Style */
        .btn-primary {
            background-color: var(--gh-btn-primary);
            border-color: rgba(27, 31, 36, 0.15);
            color: white;
            font-weight: 500;
            box-shadow: 0 1px 0 rgba(27, 31, 36, 0.1);
        }

        .btn-primary:hover {
            background-color: var(--gh-btn-hover);
            border-color: rgba(27, 31, 36, 0.15);
        }

        .btn-outline-danger {
            color: #cf222e;
            border-color: rgba(27, 31, 36, 0.15);
            background-color: #f6f8fa;
        }

        .btn-outline-danger:hover {
            background-color: #cf222e;
            color: white;
        }

        /* Alert Style GitHub */
        .alert {
            border: 1px solid var(--gh-border);
            border-radius: 6px;
            font-size: 13px;
        }

        .alert-success {
            background-color: #dafbe1;
            border-color: rgba(36, 169, 67, 0.4);
            color: var(--gh-text-primary);
        }

        .alert-danger {
            background-color: #ffebe9;
            border-color: rgba(255, 129, 130, 0.4);
            color: var(--gh-text-primary);
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .gh-container {
                flex-direction: column;
                padding: 16px;
            }

            .gh-sidebar {
                width: 100%;
                position: static;
                margin-bottom: 20px;
                border-bottom: 1px solid var(--gh-border);
                padding-bottom: 10px;
            }

            .gh-logo span {
                display: inline-block;
            }
        }
    </style>
</head>

<body>

    <header class="gh-header">
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-white d-md-none me-3 p-0" id="menu-toggle">
                <i class="fas fa-bars fs-5"></i>
            </button>
            <a href="{{ route('dashboard') }}" class="gh-logo">
                <i class="fab fa-github fa-lg"></i>
                <span>SIMPEL-SOS</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-md-block position-relative">
                {{-- <input type="text" class="form-control form-control-sm bg-dark text-white border-secondary"
                    placeholder="Type / to search" style="width: 240px; background: rgba(255,255,255,0.12) !important;">
                <span
                    class="position-absolute end-0 top-50 translate-middle-y me-2 border border-secondary rounded px-1 text-muted"
                    style="font-size: 10px;">/</span> --}}
            </div>

            <div class="vr bg-secondary mx-1 opacity-25"></div>

            <a href="{{ route('home') }}" target="_blank" class="header-item" title="Lihat Website">
                <i class="fas fa-globe"></i>
            </a>

            <div class="dropdown">
                <a href="#" class="header-item d-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random&color=fff&size=20"
                        class="rounded-circle border border-secondary" alt="Avatar">
                    <i class="fas fa-caret-down" style="font-size: 10px;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 13px;">
                    <li><span class="dropdown-header">Signed in as <strong
                                class="text-dark">{{ Auth::user()->name }}</strong></span></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Sign out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="gh-container">

        <aside class="gh-sidebar" id="sidebar-wrapper">
            <div class="profile-box d-flex d-md-none">
                <div class="avatar-circle">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                    <div class="text-muted small">{{ strtoupper(Auth::user()->role) }}</div>
                </div>
            </div>

            <div class="menu-heading">Dashboard</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Overview
            </a>

            <div class="menu-heading">Aplikasi</div>
            <a href="{{ route('admin.application.index') }}"
                class="nav-item {{ request()->routeIs('admin.application.index') || request()->routeIs('admin.application.show') ? 'active' : '' }}">
                <i class="far fa-file-alt"></i> Data Permohonan
            </a>

            @if (in_array(auth()->user()->role, ['admin', 'operator']))
                <a href="{{ route('admin.application.create') }}"
                    class="nav-item {{ request()->routeIs('admin.application.create') ? 'active' : '' }}">
                    <i class="fas fa-plus"></i> Input Baru
                </a>
            @endif

            @if (auth()->user()->role == 'admin')
                <div class="menu-heading">Administrator</div>
                <a href="{{ route('admin.services.index') }}"
                    class="nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Jenis Layanan
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Manajemen User
                </a>
            @endif

            <div class="mt-4 pt-3 border-top d-none d-md-block">
                <div class="d-flex align-items-center gap-2 mb-2 px-2">
                    <div class="avatar-circle" style="width: 32px; height: 32px; font-size: 12px;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div style="line-height: 1.2;">
                        <div class="fw-bold" style="font-size: 13px;">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 11px;">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <main class="gh-main">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <h4 class="m-0 fw-normal">@yield('title', 'Dashboard')</h4>

                <span class="text-muted small bg-white border px-2 py-1 rounded">
                    {{ date('M d, Y') }}
                </span>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <div class="d-flex align-items-center gap-2 fw-bold mb-1">
                        <i class="fas fa-exclamation-circle"></i> Please fix the following errors:
                    </div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-times-circle"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <div class="gh-content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Tweak DataTables agar sesuai style GitHub
            $('.table').addClass('table-hover border');
            $('.dataTables_wrapper .row').addClass('my-2');

            // Toggle sidebar mobile
            $('#menu-toggle').click(function() {
                $('.gh-sidebar').slideToggle();
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
