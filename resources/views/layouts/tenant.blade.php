<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tenant Portal - Boarding House Management')</title>
    
    <!-- Bootstrap 5 CSS - Local file for offline use -->
    <!-- Download from: https://getbootstrap.com/docs/5.3/getting-started/download/ -->
    <!-- Place bootstrap.min.css in public/css/ -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Font Awesome CSS - Local file for offline use -->
    <!-- Download from: https://fontawesome.com/download -->
    <!-- Place font-awesome folder in public/css/ -->
    <link href="{{ asset('css/font-awesome/all.min.css') }}" rel="stylesheet">
    
    @stack('styles')
    
    <!-- Custom styles for sidebar and layout -->
    <style>
        /* Sidebar styling */
        .sidebar {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 50%, #312e81 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
            height: 100vh;
            width: 250px;
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 0 0 40px rgba(0, 102, 255, 0.3), inset 0 0 60px rgba(0, 102, 255, 0.1);
            position: relative;
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0, 102, 255, 0.1) 0%, transparent 50%, rgba(124, 58, 237, 0.1) 100%);
            pointer-events: none;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Sidebar scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        
        
        .sidebar-link {
            transition: all 0.2s;
        }
        
        .sidebar-link {
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(180deg, var(--primary-neon), var(--secondary-neon));
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .sidebar-link:hover {
            background: linear-gradient(90deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.2));
            box-shadow: 0 0 20px rgba(0, 102, 255, 0.3), inset 0 0 30px rgba(0, 102, 255, 0.1);
            transform: translateX(5px);
        }
        
        .sidebar-link:hover::before {
            transform: scaleY(1);
        }
        
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(0, 102, 255, 0.3), rgba(124, 58, 237, 0.3));
            box-shadow: 0 4px 20px rgba(0, 102, 255, 0.4), 
                        inset 0 0 40px rgba(0, 102, 255, 0.2),
                        0 0 15px rgba(0, 102, 255, 0.3);
            border-left: 4px solid var(--primary-neon);
        }
        
        .sidebar-link.active::before {
            transform: scaleY(1);
        }
        
        .sidebar-link i {
            transition: all 0.3s ease;
            filter: drop-shadow(0 0 3px rgba(255, 255, 255, 0.3));
        }
        
        .sidebar-link:hover i,
        .sidebar-link.active i {
            filter: drop-shadow(0 0 10px rgba(0, 212, 255, 0.8));
            transform: scale(1.15);
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
        
        /* Sidebar collapsed state - hidden on mobile */
        @media (max-width: 991.98px) {
            .sidebar.collapsed {
                transform: translateX(-100%);
            }
            .sidebar:not(.collapsed) {
                transform: translateX(0);
            }
        }
        
        /* On desktop, sidebar is always visible */
        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0) !important;
            }
        }
        
        /* Main content area - add margin for sidebar on desktop */
        .main-content-wrapper {
            margin-left: 0;
        }
        
        @media (min-width: 992px) {
            .main-content-wrapper {
                margin-left: 250px; /* Sidebar width */
            }
        }
        
        /* Header gradient */
        .header-gradient {
            background: linear-gradient(135deg, rgba(0, 102, 255, 0.1), rgba(124, 58, 237, 0.1), rgba(0, 212, 255, 0.08));
        }
        
        /* CSS Variables for Futuristic Design */
        :root {
            --primary-neon: #0066ff;
            --secondary-neon: #7c3aed;
            --accent-neon: #00d4ff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --glow-primary: 0 0 30px rgba(0, 102, 255, 0.5), 0 0 60px rgba(0, 102, 255, 0.3);
            --glow-secondary: 0 0 20px rgba(124, 58, 237, 0.4);
        }
        
        /* Animated background particles */
        body.bg-light {
            position: relative;
            overflow-x: hidden;
        }
        
        body.bg-light::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(0, 102, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(124, 58, 237, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(0, 212, 255, 0.08) 0%, transparent 50%);
            background-size: 200% 200%;
            animation: backgroundFloat 20s ease infinite;
            pointer-events: none;
            z-index: 0;
        }
        
        @keyframes backgroundFloat {
            0%, 100% { background-position: 0% 0%, 100% 100%, 50% 50%; }
            50% { background-position: 100% 100%, 0% 0%, 0% 100%; }
        }
        
        .main-content-wrapper {
            position: relative;
            z-index: 1;
        }
        
        /* Futuristic Cards - Light Mode */
        .futuristic-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 2px solid rgba(0, 102, 255, 0.4);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), 
                        0 0 0 1px rgba(0, 102, 255, 0.2),
                        inset 0 1px 0 rgba(255, 255, 255, 0.6),
                        0 0 30px rgba(0, 102, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: visible;
            width: 100%;
            min-width: 0;
        }
        
        /* Colorful outline variants for cards */
        .futuristic-card.outline-primary {
            border: 2px solid rgba(0, 102, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 102, 255, 0.15), 0 0 20px rgba(0, 102, 255, 0.1);
        }
        
        .futuristic-card.outline-success {
            border: 2px solid rgba(34, 197, 94, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(34, 197, 94, 0.15), 0 0 20px rgba(34, 197, 94, 0.1);
        }
        
        .futuristic-card.outline-info {
            border: 2px solid rgba(0, 212, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 212, 255, 0.15), 0 0 20px rgba(0, 212, 255, 0.1);
        }
        
        .futuristic-card.outline-purple {
            border: 2px solid rgba(124, 58, 237, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(124, 58, 237, 0.15), 0 0 20px rgba(124, 58, 237, 0.1);
        }
        
        .futuristic-card.outline-warning {
            border: 2px solid rgba(251, 191, 36, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(251, 191, 36, 0.15), 0 0 20px rgba(251, 191, 36, 0.1);
        }
        
        .futuristic-card.outline-danger {
            border: 2px solid rgba(239, 68, 68, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(239, 68, 68, 0.15), 0 0 20px rgba(239, 68, 68, 0.1);
        }
        
        .futuristic-card.outline-gradient {
            border: 2px solid transparent;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)),
                linear-gradient(135deg, rgba(0, 102, 255, 0.4), rgba(124, 58, 237, 0.4));
            background-origin: border-box;
            background-clip: padding-box, border-box;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 0 20px rgba(0, 102, 255, 0.1);
        }
        
        /* Allow overflow for nested content but clip the gradient line */
        .futuristic-card > * {
            position: relative;
            z-index: 1;
        }
        
        /* Make card content fluid */
        .futuristic-card .d-flex {
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
            
            .futuristic-card.stat-card [style*="width: 70px"] {
                width: 60px !important;
                height: 60px !important;
                margin-top: 0.5rem;
            }
        }
        
        .futuristic-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-neon), var(--secondary-neon), var(--accent-neon));
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
            border-radius: 24px 24px 0 0;
        }
        
        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .futuristic-card:hover {
            transform: translateY(-8px) scale(1.01);
            border-color: rgba(0, 102, 255, 0.8);
            box-shadow: 0 15px 50px rgba(0, 102, 255, 0.4), 
                        var(--glow-primary), 
                        0 0 0 2px rgba(0, 102, 255, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        
        /* Enhanced hover effects for outline variants */
        .futuristic-card.outline-primary:hover {
            border-color: rgba(0, 102, 255, 0.7);
            box-shadow: 0 12px 40px rgba(0, 102, 255, 0.25), 0 0 30px rgba(0, 102, 255, 0.2), 0 0 0 2px rgba(0, 102, 255, 0.3);
        }
        
        .futuristic-card.outline-success:hover {
            border-color: rgba(34, 197, 94, 0.7);
            box-shadow: 0 12px 40px rgba(34, 197, 94, 0.25), 0 0 30px rgba(34, 197, 94, 0.2), 0 0 0 2px rgba(34, 197, 94, 0.3);
        }
        
        .futuristic-card.outline-info:hover {
            border-color: rgba(0, 212, 255, 0.7);
            box-shadow: 0 12px 40px rgba(0, 212, 255, 0.25), 0 0 30px rgba(0, 212, 255, 0.2), 0 0 0 2px rgba(0, 212, 255, 0.3);
        }
        
        .futuristic-card.outline-purple:hover {
            border-color: rgba(124, 58, 237, 0.7);
            box-shadow: 0 12px 40px rgba(124, 58, 237, 0.25), 0 0 30px rgba(124, 58, 237, 0.2), 0 0 0 2px rgba(124, 58, 237, 0.3);
        }
        
        .futuristic-card.outline-warning:hover {
            border-color: rgba(251, 191, 36, 0.7);
            box-shadow: 0 12px 40px rgba(251, 191, 36, 0.25), 0 0 30px rgba(251, 191, 36, 0.2), 0 0 0 2px rgba(251, 191, 36, 0.3);
        }
        
        .futuristic-card.outline-danger:hover {
            border-color: rgba(239, 68, 68, 0.7);
            box-shadow: 0 12px 40px rgba(239, 68, 68, 0.25), 0 0 30px rgba(239, 68, 68, 0.2), 0 0 0 2px rgba(239, 68, 68, 0.3);
        }
        
        .futuristic-card.outline-gradient:hover {
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.95)),
                linear-gradient(135deg, rgba(0, 102, 255, 0.6), rgba(124, 58, 237, 0.6));
            box-shadow: 0 12px 40px rgba(0, 102, 255, 0.25), 0 0 30px rgba(124, 58, 237, 0.2);
        }
        
        .futuristic-card:hover::before {
            opacity: 1;
        }
        
        /* Stat Card Special Styling */
        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9));
            overflow: visible !important;
        }
        
        /* Ensure nested cards and badges don't get clipped */
        .futuristic-card .futuristic-card {
            margin: 0.5rem 0;
        }
        
        /* Badge positioning fix */
        .futuristic-card .badge {
            position: relative;
            z-index: 10;
        }
        
        /* Icon boxes with shadows need space */
        .futuristic-card [style*="box-shadow"] {
            margin: 0.25rem;
        }
        
        /* Neon Button - Light Mode */
        .btn-neon {
            background: linear-gradient(135deg, var(--primary-neon), var(--secondary-neon), var(--accent-neon));
            background-size: 200% 200%;
            animation: buttonGlow 3s ease infinite;
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 16px;
            box-shadow: var(--glow-primary), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        @keyframes buttonGlow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .btn-neon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-neon:hover {
            transform: scale(1.08) translateY(-2px);
            box-shadow: 0 0 40px rgba(0, 102, 255, 0.8), 
                       0 0 60px rgba(124, 58, 237, 0.6),
                       inset 0 1px 0 rgba(255, 255, 255, 0.4);
            color: white;
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        .btn-neon:hover::before {
            width: 300px;
            height: 300px;
        }
        
        /* Futuristic Dropdown Menu */
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 2px solid rgba(0, 102, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15), 0 0 30px rgba(0, 102, 255, 0.2);
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
            height: 3px;
            background: linear-gradient(90deg, var(--primary-neon), var(--secondary-neon), var(--accent-neon));
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
            opacity: 0.9;
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
        <button id="mobile-menu-button" class="btn position-fixed d-lg-none" 
                style="top: 1rem; left: 1rem; z-index: 1050; border-radius: 0.5rem; 
                       background: linear-gradient(135deg, #0066ff, #7c3aed); 
                       border: 2px solid rgba(255, 255, 255, 0.3);
                       color: white;
                       box-shadow: 0 4px 15px rgba(0, 102, 255, 0.4), 0 0 20px rgba(0, 102, 255, 0.3);"
                onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Sidebar Navigation -->
        <!-- Collapsible sidebar that slides in/out on mobile -->
        <aside id="sidebar" class="sidebar text-white p-3 shadow-lg position-fixed" style="z-index: 1040; top: 0; left: 0;">
            <div class="d-flex flex-column">
                
                <!-- Sidebar Header: Logo and Title -->
                <div class="d-flex align-items-center mb-4 flex-shrink-0" style="position: relative; z-index: 1;">
                    <div class="p-3 rounded-3 me-3" style="background: rgba(255, 255, 255, 0.15); border: 2px solid rgba(255, 255, 255, 0.3); box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);">
                        <i class="fas fa-home fs-4" style="filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));"></i>
                    </div>
                    <div>
                        <h1 class="h5 fw-bold mb-0" style="text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);">Tenant Portal</h1>
                        <p class="small text-white-50 mb-0" style="text-shadow: 0 0 5px rgba(255, 255, 255, 0.3);">Boarding House</p>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="flex-grow-1">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('tenant.dashboard') }}" 
                               class="sidebar-link d-flex align-items-center p-3 rounded-3 text-white text-decoration-none {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt me-3"></i>
                                <span class="fw-medium">Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('tenant.profile') }}" 
                               class="sidebar-link d-flex align-items-center p-3 rounded-3 text-white text-decoration-none {{ request()->routeIs('tenant.profile') ? 'active' : '' }}">
                                <i class="fas fa-user me-3"></i>
                                <span class="fw-medium">My Profile</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('tenant.bookings.index') }}" 
                               class="sidebar-link d-flex align-items-center p-3 rounded-3 text-white text-decoration-none {{ request()->routeIs('tenant.bookings.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check me-3"></i>
                                <span class="fw-medium">My Bookings</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('tenant.rooms') }}" 
                               class="sidebar-link d-flex align-items-center p-3 rounded-3 text-white text-decoration-none {{ request()->routeIs('tenant.rooms') ? 'active' : '' }}">
                                <i class="fas fa-bed me-3"></i>
                                <span class="fw-medium">My Room</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('tenant.payments') }}" 
                               class="sidebar-link d-flex align-items-center p-3 rounded-3 text-white text-decoration-none {{ request()->routeIs('tenant.payments') ? 'active' : '' }}">
                                <i class="fas fa-credit-card me-3"></i>
                                <span class="fw-medium">Payments</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('tenant.invoices') }}" 
                               class="sidebar-link d-flex align-items-center p-3 rounded-3 text-white text-decoration-none {{ request()->routeIs('tenant.invoices') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice me-3"></i>
                                <span class="fw-medium">Invoices</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('tenant.maintenance.index') }}" 
                               class="sidebar-link d-flex align-items-center p-3 rounded-3 text-white text-decoration-none {{ request()->routeIs('tenant.maintenance.*') ? 'active' : '' }}">
                                <i class="fas fa-tools me-3"></i>
                                <span class="fw-medium">Maintenance</span>
                            </a>
                        </li>
                        
                        <li class="mb-2">
                            <a href="{{ route('tenant.notifications') }}" 
                               class="sidebar-link d-flex align-items-center p-3 rounded-3 text-white text-decoration-none {{ request()->routeIs('tenant.notifications') ? 'active' : '' }} position-relative">
                                <i class="fas fa-bell me-3"></i>
                                <span class="fw-medium">Notifications</span>
                                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle ms-2">3</span>
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
            <header class="bg-white shadow-sm border-bottom">
                <div class="header-gradient position-absolute top-0 start-0 w-100 h-100 opacity-50"></div>
                <div class="container-fluid position-relative">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3 px-3 px-md-4 gap-3">
                        <!-- Page Title Section -->
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 rounded" style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.2)); color: #0066ff; box-shadow: 0 0 15px rgba(0, 102, 255, 0.3);">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <div>
                                <h2 class="h4 fw-bold text-dark mb-0">@yield('page-title', 'Dashboard')</h2>
                                <p class="small text-muted mb-0 d-none d-md-block">Manage your boarding house activities</p>
                            </div>
                        </div>
                        
                        <!-- Header Actions: Notifications, User Menu, Logout -->
                        <div class="d-flex align-items-center gap-2 gap-md-3">
                            <!-- Notifications Icon -->
                            <a href="{{ route('tenant.notifications') }}" 
                               class="btn btn-light position-relative p-2" 
                               title="Notifications">
                                <i class="fas fa-bell text-muted"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                            </a>
                            
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
                                        <p class="small mb-0" style="color: var(--text-secondary);">Tenant</p>
                                    </div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 32px; height: 32px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(124, 58, 237, 0.3)); border: 2px solid rgba(0, 102, 255, 0.5); box-shadow: 0 0 15px rgba(0, 102, 255, 0.4);">
                                        <i class="fas fa-user small" style="color: #0066ff; filter: drop-shadow(0 0 5px rgba(0, 102, 255, 0.5));"></i>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="min-width: 220px;">
                                    <li>
                                        <div class="dropdown-item-text px-3 py-3">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(124, 58, 237, 0.3)); border: 2px solid rgba(0, 102, 255, 0.5); box-shadow: 0 0 20px rgba(0, 102, 255, 0.5);">
                                                    <i class="fas fa-user" style="color: #0066ff; filter: drop-shadow(0 0 5px rgba(0, 102, 255, 0.5));"></i>
                                                </div>
                                                <div>
                                                    <p class="small fw-bold mb-0" style="color: var(--text-primary);">{{ session('user_name') }}</p>
                                                    <p class="small mb-0" style="color: var(--text-secondary);">{{ session('user_email') ?? 'Tenant Account' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('tenant.profile') }}">
                                            <i class="fas fa-user me-2" style="color: #0066ff;"></i>My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('tenant.dashboard') }}">
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
            const navLinks = document.querySelectorAll('.sidebar-link');
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
            } else {
                sidebar.classList.add('collapsed');
            }
        });
    </script>
</body>
</html>
