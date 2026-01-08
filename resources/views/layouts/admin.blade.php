<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Boarding House Management')</title>
    
    <!-- Bootstrap 5 CSS - Local file for offline use -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Font Awesome CSS - Local file for offline use -->
    <link href="{{ asset('css/font-awesome/all.min.css') }}" rel="stylesheet">
    
    @stack('styles')
    
    <!-- Futuristic Admin Design Styles - Light Mode -->
    <style>
        /* Global Futuristic Theme - Light Mode */
        :root {
            --primary-neon: #0066ff;
            --secondary-neon: #7c3aed;
            --accent-neon: #ec4899;
            --light-bg: #f8fafc;
            --light-card: #ffffff;
            --light-border: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --glow-primary: 0 0 20px rgba(0, 102, 255, 0.3);
            --glow-secondary: 0 0 20px rgba(124, 58, 237, 0.3);
        }
        
        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e0e7ff 50%, #f8fafc 100%);
            color: var(--text-primary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated Background Particles - Light Mode */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(0, 102, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(124, 58, 237, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(236, 72, 153, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
            animation: pulse 15s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 0.9; }
        }
        
        /* Futuristic Sidebar - Blue Theme */
        .admin-sidebar {
            background: linear-gradient(180deg, #0066ff 0%, #0052cc 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 2px 0 30px rgba(0, 0, 0, 0.2), inset -1px 0 0 rgba(255, 255, 255, 0.1);
            height: 100vh;
            max-height: 100vh;
            width: 300px;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1000;
            overflow: hidden;
        }
        
        .admin-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.5));
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }
        
        /* Sidebar collapsed state - hidden on mobile */
        @media (max-width: 991.98px) {
            .admin-sidebar.collapsed {
                transform: translateX(-100%);
            }
            .admin-sidebar:not(.collapsed) {
                transform: translateX(0);
            }
        }
        
        /* On desktop, sidebar is always visible */
        @media (min-width: 992px) {
            .admin-sidebar {
                transform: translateX(0) !important;
            }
        }
        
        /* Sidebar Header */
        .sidebar-header {
            padding: 1.3rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 0.75rem;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .sidebar-logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
            animation: glow-pulse 2s ease-in-out infinite;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .sidebar-logo-icon i {
            font-size: 1.3rem;
        }
        
        @keyframes glow-pulse {
            0%, 100% { box-shadow: 0 0 15px rgba(255, 255, 255, 0.3); }
            50% { box-shadow: 0 0 25px rgba(255, 255, 255, 0.5); }
        }
        
        .sidebar-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        /* Sidebar Navigation Links - Blue Theme */
        .admin-sidebar-link {
            position: relative;
            padding: 0.9rem 1.2rem;
            margin: 0.4rem 0.85rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 1rem;
            overflow: hidden;
            font-size: 1.05rem;
            font-weight: 500;
        }
        
        .admin-sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .admin-sidebar-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .admin-sidebar-link:hover::before {
            transform: scaleY(1);
        }
        
        .admin-sidebar-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            font-weight: 600;
        }
        
        .admin-sidebar-link.active::before {
            transform: scaleY(1);
        }
        
        .admin-sidebar-link i {
            width: 26px;
            text-align: center;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        /* Mobile overlay - Light Mode */
        .mobile-overlay {
            display: none;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }
        
        .mobile-overlay.show {
            display: block;
        }
        
        @media (min-width: 992px) {
            .mobile-overlay {
                display: none !important;
            }
        }
        
        /* Main content area - add margin for sidebar on desktop */
        .main-content-wrapper {
            margin-left: 0;
            position: relative;
            z-index: 1;
        }
        
        @media (min-width: 992px) {
            .main-content-wrapper {
                margin-left: 280px; /* Sidebar width */
            }
        }
        
        /* Futuristic Header - Light Mode */
        .futuristic-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 102, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 100;
        }
        
        .futuristic-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary-neon), transparent);
            box-shadow: 0 0 10px rgba(0, 102, 255, 0.5);
        }
        
        /* Futuristic Cards - Light Mode */
        .futuristic-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 102, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
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
        }
        
        .futuristic-card:hover {
            transform: translateY(-5px);
            border-color: rgba(0, 102, 255, 0.4);
            box-shadow: 0 12px 40px rgba(0, 102, 255, 0.15), var(--glow-primary);
        }
        
        .futuristic-card:hover::before {
            opacity: 1;
        }
        
        /* Neon Button - Light Mode */
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
        }
        
        .btn-neon:hover::before {
            width: 300px;
            height: 300px;
        }
        
        /* Mobile Menu Button */
        #mobile-menu-button {
            background: linear-gradient(135deg, var(--primary-neon), var(--secondary-neon));
            border: none;
            box-shadow: var(--glow-primary);
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }
        
        /* Stats Card Glow Effect */
        .stat-card {
            position: relative;
            overflow: visible;
            width: 100%;
            min-width: 0;
        }
        
        /* Make card content fluid */
        .stat-card .d-flex {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        /* Responsive adjustments for stat cards */
        @media (max-width: 768px) {
            .futuristic-card.stat-card {
                padding: 1rem !important;
            }
            
            .futuristic-card.stat-card .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .futuristic-card.stat-card [style*="width: 55px"] {
                width: 50px !important;
                height: 50px !important;
                margin-top: 0.5rem;
            }
        }
        
        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.1) 0%, transparent 70%);
            animation: rotate 10s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Text Glow Effects */
        .text-glow {
            text-shadow: 0 0 10px currentColor, 0 0 20px currentColor, 0 0 30px currentColor;
        }
        
        /* Scrollbar Styling - Light Mode */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(241, 245, 249, 0.8);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary-neon), var(--secondary-neon));
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--secondary-neon), var(--primary-neon));
        }
        
        /* User Dropdown Styling */
        .dropdown-toggle::after {
            display: none;
        }
        
        .futuristic-header {
            position: relative;
            z-index: 1030;
        }
        
        .futuristic-header .dropdown {
            position: relative;
            z-index: 1031;
        }
        
        .futuristic-header .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1), 0 0 20px rgba(0, 102, 255, 0.1);
            animation: slideDown 0.3s ease-out;
            z-index: 1050 !important;
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-item {
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(0, 102, 255, 0.08);
            color: var(--primary-neon) !important;
        }
        
        .dropdown-item:focus {
            background: rgba(0, 102, 255, 0.08);
        }
        
        /* Ensure images display in normal color without filters */
        img {
            filter: none !important;
            -webkit-filter: none !important;
        }
        
        /* Specifically for receipt images */
        img[alt="Payment Receipt"] {
            filter: none !important;
            -webkit-filter: none !important;
        }
    </style>
</head>
<body>
    <!-- Main Container: Flexbox layout for sidebar and content -->
    <div class="d-flex">
        
        <!-- Mobile Menu Toggle Button -->
        <button id="mobile-menu-button" class="btn btn-neon position-fixed d-lg-none" 
                style="top: 1rem; left: 1rem; z-index: 1050;"
                onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Futuristic Sidebar Navigation -->
        <aside id="sidebar" class="admin-sidebar text-white p-0 shadow-lg position-fixed" style="z-index: 1040; top: 0; left: 0;">
            <div class="d-flex flex-column h-100" style="height: 100%; max-height: 100vh;">
                
                <!-- Sidebar Header: Logo and Title -->
                <div class="sidebar-header" style="flex-shrink: 0;">
                    <div class="sidebar-logo">
                        <div class="sidebar-logo-icon">
                            <i class="fas fa-cube text-white"></i>
                        </div>
                        <div>
                            <h1 class="sidebar-title mb-0">ADMIN</h1>
                            <p class="small mb-0" style="font-size: 0.85rem; letter-spacing: 2px; color: rgba(255, 255, 255, 0.8);">CONTROL PANEL</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="flex-grow-1 px-2" style="overflow: hidden; min-height: 0; flex: 1 1 auto;">
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.tenants.index') }}" 
                               class="admin-sidebar-link {{ request()->routeIs('admin.tenants.*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                <span>Tenants</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.rooms.index') }}" 
                               class="admin-sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                                <i class="fas fa-bed"></i>
                                <span>Rooms</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="admin-sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check"></i>
                                <span>Bookings</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.payments.index') }}" 
                               class="admin-sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                                <i class="fas fa-credit-card"></i>
                                <span>Payments</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.invoices') }}" 
                               class="admin-sidebar-link {{ request()->routeIs('admin.invoices') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice"></i>
                                <span>Invoices</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.maintenance.index') }}" 
                               class="admin-sidebar-link {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                                <i class="fas fa-tools"></i>
                                <span>Maintenance</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="/admin/reports?view=revenue" 
                               class="admin-sidebar-link {{ request()->routeIs('admin.reports.*') || request()->get('view') == 'revenue' ? 'active' : '' }}">
                                <i class="fas fa-chart-line"></i>
                                <span>Reports & Analytics</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Mobile Overlay -->
        <div id="mobile-overlay" class="mobile-overlay position-fixed top-0 start-0 w-100 h-100" 
             style="z-index: 1035; display: none;" onclick="closeSidebar()"></div>
        
        <!-- Main Content Area -->
        <div class="flex-grow-1 d-flex flex-column main-content-wrapper">
            
            <!-- Futuristic Header -->
            <header class="futuristic-header">
                <div class="container-fluid">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3 px-3 px-md-4 gap-3">
                        <!-- Page Title -->
                        <div>
                            <h2 class="h4 fw-bold mb-0" style="color: var(--primary-neon);">
                                @yield('page-title', 'Dashboard')
                            </h2>
                            <p class="small mb-0 d-none d-md-block" style="color: var(--text-secondary);">Control & Monitor System</p>
                        </div>
                        
                        <!-- Header Actions: User Dropdown -->
                        <div class="dropdown" style="position: relative;">
                            <button class="btn btn-neon btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border: none;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 35px; height: 35px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.2)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                    <i class="fas fa-user" style="color: #0066ff; font-size: 0.9rem;"></i>
                                </div>
                                <span class="d-none d-md-inline" style="color: var(--text-primary); font-weight: 600;">{{ session('user_name') }}</span>
                                <i class="fas fa-chevron-down d-none d-md-inline" style="color: var(--text-secondary); font-size: 0.75rem;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end futuristic-card shadow-lg" aria-labelledby="userDropdown" 
                                style="border: 1px solid rgba(0, 102, 255, 0.2); min-width: 250px; margin-top: 0.5rem; padding: 0;">
                                <li class="px-3 py-3 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: rgba(0, 102, 255, 0.02);">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.2)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                            <i class="fas fa-user" style="color: #0066ff;"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold" style="color: var(--text-primary);">{{ session('user_name') }}</div>
                                            <div class="small" style="color: var(--text-secondary);">{{ session('user_email') }}</div>
                                            <div class="small mt-1">
                                                <span class="badge px-2 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff; text-transform: uppercase; font-size: 0.65rem;">
                                                    Admin
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2" style="color: #ef4444; padding: 0.75rem 1rem;">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content: Main content area with padding -->
            <main class="flex-grow-1 overflow-auto p-3 p-md-4" style="position: relative; z-index: 1; background: transparent; margin-top: 0;">
                <!-- Success/Error Messages: Flash notifications -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show futuristic-card" role="alert" style="border-color: rgba(34, 197, 94, 0.5);">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show futuristic-card" role="alert" style="border-color: rgba(239, 68, 68, 0.5);">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Page Content: Yields to child views -->
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle - Local file for offline use -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    @stack('scripts')
    
    <!-- Mobile Sidebar Toggle Script -->
    <script>
        // Verify Bootstrap is loaded and initialize components
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all Bootstrap dropdowns
            const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
            if (typeof bootstrap !== 'undefined') {
                const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl));
            }
            
            // Initialize Bootstrap tooltips if needed
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            if (typeof bootstrap !== 'undefined' && tooltipTriggerList.length > 0) {
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            }
        });
        
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
        
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            sidebar.classList.add('collapsed');
            overlay.style.display = 'none';
            overlay.classList.remove('show');
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.admin-sidebar-link');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        closeSidebar();
                    }
                });
            });
            
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('collapsed');
                    overlay.style.display = 'none';
                } else {
                    sidebar.classList.add('collapsed');
                }
            });
            
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('collapsed');
            } else {
                sidebar.classList.add('collapsed');
            }
        });
    </script>
</body>
</html>
