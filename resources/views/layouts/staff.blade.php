<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Staff Portal - Boarding House Management')</title>
    
    <!-- Bootstrap 5 CSS - Local file for offline use -->
    <!-- Download from: https://getbootstrap.com/docs/5.3/getting-started/download/ -->
    <!-- Place bootstrap.min.css in public/css/ -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Font Awesome CSS - Local file for offline use -->
    <!-- Download from: https://fontawesome.com/download -->
    <!-- Place font-awesome folder in public/css/ -->
    <link href="{{ asset('css/font-awesome/all.min.css') }}" rel="stylesheet">
    
    @stack('styles')
    
    <!-- Custom styles for staff sidebar and layout -->
    <style>
        /* CSS Variables for Futuristic Design */
        :root {
            --primary-neon: #0066ff;
            --secondary-neon: #7c3aed;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --glow-primary: 0 0 20px rgba(0, 102, 255, 0.3);
        }
        
        /* Staff sidebar styling - Futuristic */
        .staff-sidebar {
            background: linear-gradient(135deg, #166534 0%, #15803d 50%, #16a34a 100%);
            min-height: 100vh;
            height: 100vh;
            width: 250px;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.2), inset -1px 0 0 rgba(255, 255, 255, 0.1);
            position: relative;
        }
        
        .staff-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.3));
            opacity: 0.5;
        }
        
        /* Sidebar scrollbar styling */
        .staff-sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .staff-sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .staff-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        
        .staff-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        
        .staff-sidebar.collapsed {
            transform: translateX(-100%);
        }
        
        @media (min-width: 992px) {
            .staff-sidebar.collapsed {
                transform: translateX(0);
            }
        }
        
        .staff-sidebar-link {
            transition: all 0.3s ease;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .staff-sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary-neon), var(--secondary-neon));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .staff-sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        
        .staff-sidebar-link:hover::before {
            opacity: 1;
        }
        
        .staff-sidebar-link:hover > div[style*="background: rgba(255, 255, 255, 0.1)"] {
            background: rgba(255, 255, 255, 0.25) !important;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        
        .staff-sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .staff-sidebar-link.active::before {
            opacity: 1;
        }
        
        .staff-sidebar-link.active > div[style*="background: rgba(255, 255, 255, 0.1)"] {
            background: rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
        }
        
        /* Mobile overlay */
        .mobile-overlay {
            display: none;
        }
        
        .mobile-overlay.show {
            display: block;
        }
        
        @media (min-width: 992px) {
            .mobile-overlay {
                display: none !important;
            }
        }
        
        /* Futuristic Cards */
        .futuristic-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 102, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: visible;
            width: 100%;
            min-width: 0;
        }
        
        .futuristic-card > * {
            position: relative;
            z-index: 1;
        }
        
        .futuristic-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-neon), var(--secondary-neon));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
            border-radius: 20px 20px 0 0;
        }
        
        .futuristic-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 102, 255, 0.4);
            box-shadow: 0 12px 40px rgba(0, 102, 255, 0.15), var(--glow-primary);
        }
        
        .futuristic-card:hover::before {
            opacity: 1;
        }
        
        /* Stat Card Special Styling */
        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9));
            overflow: visible !important;
        }
        
        /* Neon Button */
        .btn-neon {
            background: linear-gradient(135deg, var(--primary-neon), var(--secondary-neon));
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            box-shadow: var(--glow-primary);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-neon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-neon:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(0, 102, 255, 0.6);
            color: white;
        }
        
        .btn-neon:hover::before {
            width: 300px;
            height: 300px;
        }
        
        /* Futuristic Badges */
        .badge-futuristic {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Header gradient */
        .header-gradient {
            background: linear-gradient(to right, #eff6ff, #e0e7ff);
        }
        
        /* Main content area - add margin for sidebar on desktop */
        .main-content-wrapper {
            margin-left: 0;
            width: 100%;
        }
        
        @media (min-width: 992px) {
            .main-content-wrapper {
                margin-left: 250px; /* Sidebar width */
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .futuristic-card.stat-card {
                padding: 1rem !important;
            }
        }
        
        /* Futuristic Dropdown Menu */
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 102, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 0 20px rgba(0, 102, 255, 0.1);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-neon), var(--secondary-neon));
            opacity: 0.8;
        }
        
        .dropdown-item {
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
            color: var(--text-primary);
            border-left: 3px solid transparent;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(90deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1));
            border-left-color: var(--primary-neon);
            color: var(--primary-neon);
            transform: translateX(4px);
        }
        
        .dropdown-item-text {
            background: linear-gradient(135deg, rgba(0, 102, 255, 0.05), rgba(124, 58, 237, 0.05));
            border-bottom: 1px solid rgba(0, 102, 255, 0.1);
        }
        
        .dropdown-item.text-danger {
            color: #ef4444 !important;
        }
        
        .dropdown-item.text-danger:hover {
            background: linear-gradient(90deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            border-left-color: #ef4444;
            color: #dc2626 !important;
        }
        
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: rgba(0, 102, 255, 0.1);
        }
        
        .dropdown-toggle::after {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }
        
        .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }
        
        .dropdown-toggle {
            transition: all 0.3s ease;
        }
        
        .dropdown-toggle:hover {
            background: rgba(0, 102, 255, 0.05) !important;
            box-shadow: 0 4px 12px rgba(0, 102, 255, 0.15);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Main Container: Flexbox layout for sidebar and content -->
    <div class="d-flex">
        
        <!-- Mobile Menu Toggle Button -->
        <!-- Visible only on mobile/tablet screens -->
        <button id="mobile-menu-button" class="btn btn-success position-fixed d-lg-none" 
                style="top: 1rem; left: 1rem; z-index: 1050; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Sidebar Navigation -->
        <!-- Collapsible sidebar that slides in/out on mobile -->
        <aside id="sidebar" class="staff-sidebar text-white p-3 p-md-4 shadow-lg position-fixed d-lg-block collapsed" style="z-index: 1040;">
            <div class="d-flex flex-column h-100">
                
                <!-- Sidebar Header: Logo and Title -->
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom" style="border-color: rgba(255, 255, 255, 0.2) !important; flex-shrink: 0;">
                    <div class="d-flex align-items-center justify-content-center me-3" 
                         style="width: 45px; height: 45px; background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1)); border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);">
                        <i class="fas fa-tools fs-5" style="color: #fff; text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);"></i>
                    </div>
                    <h1 class="h5 fw-bold mb-0" style="text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); letter-spacing: 0.5px;">Staff Portal</h1>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="flex-grow-1">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('staff.dashboard') }}" 
                               class="staff-sidebar-link d-flex align-items-center p-3 rounded text-white text-decoration-none {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                                <div class="d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                     style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 10px; transition: all 0.3s ease;">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                <span class="fw-medium" style="letter-spacing: 0.3px;">Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('staff.tasks') }}" 
                               class="staff-sidebar-link d-flex align-items-center p-3 rounded text-white text-decoration-none {{ request()->routeIs('staff.tasks') || request()->routeIs('staff.tasks.*') ? 'active' : '' }}">
                                <div class="d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                     style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 10px; transition: all 0.3s ease;">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <span class="fw-medium" style="letter-spacing: 0.3px;">My Tasks</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('staff.maintenance') }}" 
                               class="staff-sidebar-link d-flex align-items-center p-3 rounded text-white text-decoration-none {{ request()->routeIs('staff.maintenance') || request()->routeIs('staff.maintenance.*') ? 'active' : '' }}">
                                <div class="d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                     style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 10px; transition: all 0.3s ease;">
                                    <i class="fas fa-wrench"></i>
                                </div>
                                <span class="fw-medium" style="letter-spacing: 0.3px;">Maintenance</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('staff.notifications') }}" 
                               class="staff-sidebar-link d-flex align-items-center p-3 rounded text-white text-decoration-none {{ request()->routeIs('staff.notifications') ? 'active' : '' }}">
                                <div class="d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                     style="width: 40px; height: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 10px; transition: all 0.3s ease;">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <span class="fw-medium" style="letter-spacing: 0.3px;">Notifications</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Mobile Overlay: Darkens background when sidebar is open on mobile -->
        <div id="mobile-overlay" class="mobile-overlay position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" 
             style="z-index: 1035; display: none;" onclick="closeSidebar()"></div>
        
        <!-- Main Content Area -->
        <div class="flex-grow-1 d-flex flex-column main-content-wrapper">
            
            <!-- Header: Top navigation bar -->
            <header class="header-gradient shadow-sm border-bottom" style="border-color: rgba(0, 102, 255, 0.1) !important;">
                <div class="container-fluid">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3 px-3 px-md-4 gap-3">
                        <!-- Page Title -->
                        <h2 class="h4 fw-semibold mb-0" style="color: var(--text-primary); background: linear-gradient(135deg, var(--primary-neon), var(--secondary-neon)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">@yield('page-title', 'Dashboard')</h2>
                        
                        <!-- Header Actions: User Dropdown Menu -->
                        <div class="d-flex align-items-center gap-3">
                            <!-- User Dropdown Menu -->
                            <div class="dropdown">
                                <button class="btn btn-light d-flex align-items-center gap-2 p-2 dropdown-toggle" 
                                        type="button" 
                                        id="userDropdown" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false"
                                        style="border: 1px solid rgba(0, 102, 255, 0.2); border-radius: 12px;">
                                    <div class="text-end d-none d-md-block">
                                        <p class="small fw-medium mb-0" style="color: var(--text-primary);">{{ session('user_name') }}</p>
                                        <p class="small mb-0" style="color: var(--text-secondary);">Staff</p>
                                    </div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 32px; height: 32px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.2)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                        <i class="fas fa-user small" style="color: #0066ff;"></i>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="min-width: 220px;">
                                    <li>
                                        <div class="dropdown-item-text px-3 py-3">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.2)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                                    <i class="fas fa-user" style="color: #0066ff;"></i>
                                                </div>
                                                <div>
                                                    <p class="small fw-bold mb-0" style="color: var(--text-primary);">{{ session('user_name') }}</p>
                                                    <p class="small mb-0" style="color: var(--text-secondary);">{{ session('user_email') ?? 'Staff Account' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('staff.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2" style="color: #0066ff;"></i>Dashboard
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content: Main content area with padding -->
            <main class="flex-grow-1 overflow-auto bg-light p-3 p-md-4">
                <!-- Success/Error Messages: Flash notifications -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Page Content: Yields to child views -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle - Local file for offline use -->
    <!-- Place bootstrap.bundle.min.js in public/js/ -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    @stack('scripts')
    
    <!-- Mobile Sidebar Toggle Script -->
    <script>
        // Toggle sidebar visibility on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.toggle('collapsed');
            if (overlay.style.display === 'none' || !overlay.style.display) {
                overlay.style.display = 'block';
                overlay.classList.add('show');
            } else {
                overlay.style.display = 'none';
                overlay.classList.remove('show');
            }
        }
        
        // Close sidebar function
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.add('collapsed');
            overlay.style.display = 'none';
            overlay.classList.remove('show');
        }
        
        // Close sidebar when clicking navigation links on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.staff-sidebar-link');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        closeSidebar();
                    }
                });
            });
            
            // Handle window resize - show sidebar on desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('collapsed');
                    overlay.style.display = 'none';
                } else {
                    sidebar.classList.add('collapsed');
                }
            });
            
            // Initialize sidebar state based on screen size
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('collapsed');
            }
        });
    </script>
</body>
</html>
