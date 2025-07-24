<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('AdminCss/layout.css') }}">
</head>
<body>
    <div id="wrapper">
                <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar">
                <div class="sidebar-brand">
                    <img src="{{ asset('ImageHome/logoptun-removebg-preview.png') }}" alt="PTUN Logo">
                    <p>Pengadilan Tata Usaha Negara Bandung </p>
                </div>
                <div class="flex-grow-1">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/statistik*') ? 'active' : '' }}" href="{{ route('admin.statistik') }}">
                                <i class="fas fa-chart-bar"></i>
                                Statistik Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}" href="#">
                                <i class="fas fa-calendar"></i>
                                Laporan Harian
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/pengaturan*') ? 'active' : '' }}" href="#">
                                <i class="fas fa-cog"></i>
                                Pengaturan
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebar-footer">
                    <form action="{{ route('admin.logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-logout w-100">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg fixed-top">
                <div class="container-fluid">
                    <button id="menu-toggle" class="me-2">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-book me-2"></i> Buku Tamu
                    </a>
                </div>
            </nav>

            <div class="container-fluid" style="padding-top: 4.5rem;">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("menu-toggle").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("wrapper").classList.toggle("toggled");
            document.body.classList.toggle("sidebar-shown");
        });
    </script>
    @stack('scripts')
</body>
</html>
