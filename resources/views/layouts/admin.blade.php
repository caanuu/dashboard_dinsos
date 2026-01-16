<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SIKASOS Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --light: #f8fafc;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: var(--dark);
        }

        /* Sidebar Modern */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: white;
            padding: 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .sidebar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand:hover {
            color: rgba(255,255,255,0.9);
        }

        .sidebar-subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .menu-section-title {
            color: #94a3b8;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
            margin-top: 1.5rem;
        }

        .menu-section-title:first-child {
            margin-top: 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
            font-weight: 500;
        }

        .menu-item:hover {
            background: #f8fafc;
            color: var(--primary);
        }

        .menu-item.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.1) 0%, transparent 100%);
            color: var(--primary);
            font-weight: 600;
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--primary);
        }

        .menu-item i {
            width: 20px;
            margin-right: 0.875rem;
            font-size: 1.1rem;
        }

        /* User Profile */
        .sidebar-user {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            color: var(--dark);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            color: #94a3b8;
            font-size: 0.75rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top Bar */
        .topbar {
            background: white;
            padding: 1.25rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-topbar {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            color: var(--dark);
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-topbar:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: var(--dark);
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Modern Cards */
        .card-modern {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        .card-modern:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Stats Card */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .stat-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Alerts */
        .alert {
            border-radius: 12px;
            border: none;
        }

        /* Badges */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        @stack('styles')
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <i class="fas fa-hands-helping"></i>
                <div>
                    <div>SIKASOS</div>
                    <div class="sidebar-subtitle">Admin Panel</div>
                </div>
            </a>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section-title">Dashboard</div>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Overview</span>
            </a>

            <div class="menu-section-title">Permohonan</div>
            <a href="{{ route('admin.application.index') }}" class="menu-item {{ request()->routeIs('admin.application.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Kelola Permohonan</span>
            </a>

            <div class="menu-section-title">Laporan</div>
            <a href="{{ route('admin.export.page') }}" class="menu-item {{ request()->routeIs('admin.export.*') ? 'active' : '' }}">
                <i class="fas fa-download"></i>
                <span>Export Laporan</span>
            </a>

            @if(auth()->user()->role == 'admin')
                <div class="menu-section-title">Master Data</div>
                <a href="{{ route('admin.services.index') }}" class="menu-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Jenis Layanan</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Manajemen User</span>
                </a>
            @endif
        </nav>

        <div class="sidebar-user">
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div>
                <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('home') }}" target="_blank" class="btn-topbar">
                    <i class="fas fa-globe"></i>
                    <span>Website</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-topbar text-danger border-0">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Alerts -->
            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <strong><i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success mb-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-3">
                    <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Mobile Sidebar Toggle
        $(document).ready(function() {
            // Create overlay
            if (!$('.sidebar-overlay').length) {
                $('body').append('<div class="sidebar-overlay"></div>');
            }

            // Toggle sidebar on button click
            $('#sidebarToggle, .sidebar-overlay').on('click', function() {
                $('.sidebar').toggleClass('show');
                $('.sidebar-overlay').toggleClass('show');
                $('body').toggleClass('sidebar-open');
            });

            // Close sidebar when clicking menu item on mobile
            if ($(window).width() < 992) {
                $('.menu-item').on('click', function() {
                    $('.sidebar').removeClass('show');
                    $('.sidebar-overlay').removeClass('show');
                    $('body').removeClass('sidebar-open');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
