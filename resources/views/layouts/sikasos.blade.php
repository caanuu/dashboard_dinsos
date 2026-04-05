<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - SIKASOS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background */
        .bg-animated {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .bg-animated::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Floating Shapes */
        .shape {
            position: fixed;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite;
        }

        .shape1 {
            width: 300px;
            height: 300px;
            background: white;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape2 {
            width: 200px;
            height: 200px;
            background: white;
            bottom: 20%;
            right: 15%;
            animation-delay: 5s;
        }

        .shape3 {
            width: 150px;
            height: 150px;
            background: white;
            top: 60%;
            left: 70%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-50px) rotate(180deg); }
        }

        /* Main Container */
        .main-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            padding: 2rem;
        }

        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Top Bar */
        .top-bar {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 1.25rem 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .brand-logo {
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            color: white;
        }

        .user-avatar-top {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* Navigation Pills */
        .nav-pills-custom {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 0.75rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .nav-pill {
            padding: 0.875rem 1.75rem;
            border-radius: 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-pill:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .nav-pill.active {
            background: white;
            color: #667eea;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Stats Card */
        .stat-card-glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
            height: 100%;
        }

        .stat-card-glass:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .stat-icon-glass {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .stat-value-glass {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.5rem;
        }

        .stat-label-glass {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 600;
        }

        /* Content Card */
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Buttons */
        .btn-glass {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-glass:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
        }

        .btn-solid {
            background: white;
            color: #667eea;
        }

        .btn-solid:hover {
            background: rgba(255, 255, 255, 0.9);
            color: #667eea;
        }

        /* Table */
        .table-glass {
            background: transparent;
            color: #1e293b;
        }

        .table-glass thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table-glass thead th {
            padding: 1.25rem;
            font-weight: 600;
            border: none;
        }

        .table-glass tbody td {
            padding: 1.25rem;
            background: rgba(255, 255, 255, 0.5);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .table-glass tbody tr:hover td {
            background: rgba(255, 255, 255, 0.7);
        }

        /* Badge */
        .badge-glass {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        @stack('styles')
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animated"></div>
    <div class="shape shape1"></div>
    <div class="shape shape2"></div>
    <div class="shape shape3"></div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="container-fluid" style="max-width: 1400px;">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('masyarakat.dashboard') }}" class="brand-logo">
                        <i class="fas fa-hands-helping"></i>
                        <span>SIKASOS</span>
                    </a>
                    
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('home') }}" target="_blank" class="text-white text-decoration-none">
                            <i class="fas fa-globe me-2"></i>Website
                        </a>
                        
                        <div class="user-profile">
                            <div class="user-avatar-top">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="d-none d-md-block">
                                <div style="font-weight: 600;">{{ Auth::user()->name }}</div>
                                <div style="font-size: 0.875rem; opacity: 0.8;">Masyarakat</div>
                            </div>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                                @csrf
                                <button type="submit" class="btn btn-link text-white p-0" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Pills -->
            <div class="nav-pills-custom">
                <a href="{{ route('masyarakat.dashboard') }}" class="nav-pill {{ request()->routeIs('masyarakat.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('masyarakat.applications.create') }}" class="nav-pill {{ request()->routeIs('masyarakat.applications.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle"></i>
                    <span>Ajukan Bantuan</span>
                </a>
                <a href="{{ route('masyarakat.applications.index') }}" class="nav-pill {{ request()->routeIs('masyarakat.applications.index') || request()->routeIs('masyarakat.applications.show') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    <span>Pengajuan Saya</span>
                </a>
                <a href="{{ route('masyarakat.profile') }}" class="nav-pill {{ request()->routeIs('masyarakat.profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profil</span>
                </a>
            </div>

            <!-- Alerts -->
            @if($errors->any())
                <div class="alert alert-danger rounded-4 mb-3">
                    <strong><i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success rounded-4 mb-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
