@extends('layouts.admin')

@section('title', 'Reports & Analytics')
@section('page-title', 'Reports & Analytics')

@section('content')
<div class="row g-4 mb-4">
    <!-- Revenue Overview -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="futuristic-card stat-card p-4" style="border: 2px solid rgba(34, 197, 94, 0.5); background: linear-gradient(135deg, #22c55e, #16a34a, #15803d); box-shadow: 0 12px 50px rgba(34, 197, 94, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1); border-radius: 20px; backdrop-filter: blur(15px); position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); min-height: 140px;" onmouseover="this.style.transform='translateY(-10px) scale(1.03)'; this.style.boxShadow='0 20px 70px rgba(34, 197, 94, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.25) inset, inset 0 2px 15px rgba(255, 255, 255, 0.15)';" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 12px 50px rgba(34, 197, 94, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1)';">
            <!-- Animated background glow -->
            <div style="position: absolute; top: -40%; right: -25%; width: 220px; height: 220px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%); border-radius: 50%; animation: pulse-glow 4s ease-in-out infinite;"></div>
            <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 1;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.25); border: 3px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.2) rotate(10deg)'; this.style.boxShadow='0 10px 40px rgba(255, 255, 255, 0.4), 0 0 60px rgba(255, 255, 255, 0.3) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset';">
                    <i class="fas fa-dollar-sign" style="font-size: 2rem; color: white; text-shadow: 0 0 30px rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3); filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.6));"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="small mb-2 fw-bold" style="color: rgba(255, 255, 255, 0.95); text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.75rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Total Revenue</p>
                    <p class="h3 fw-bold mb-0" style="color: white; text-shadow: 0 0 35px rgba(255, 255, 255, 0.6), 0 4px 10px rgba(0, 0, 0, 0.3); letter-spacing: -0.5px; font-size: 1.75rem;">₱{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="futuristic-card stat-card p-4" style="border: 2px solid rgba(0, 102, 255, 0.5); background: linear-gradient(135deg, #0066ff, #3b82f6, #2563eb); box-shadow: 0 12px 50px rgba(0, 102, 255, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1); border-radius: 20px; backdrop-filter: blur(15px); position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); min-height: 140px;" onmouseover="this.style.transform='translateY(-10px) scale(1.03)'; this.style.boxShadow='0 20px 70px rgba(0, 102, 255, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.25) inset, inset 0 2px 15px rgba(255, 255, 255, 0.15)';" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 12px 50px rgba(0, 102, 255, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1)';">
            <!-- Animated background glow -->
            <div style="position: absolute; top: -40%; right: -25%; width: 220px; height: 220px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%); border-radius: 50%; animation: pulse-glow 4s ease-in-out infinite;"></div>
            <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 1;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.25); border: 3px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.2) rotate(10deg)'; this.style.boxShadow='0 10px 40px rgba(255, 255, 255, 0.4), 0 0 60px rgba(255, 255, 255, 0.3) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset';">
                    <i class="fas fa-calendar-month" style="font-size: 2rem; color: white; text-shadow: 0 0 30px rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3); filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.6));"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="small mb-2 fw-bold" style="color: rgba(255, 255, 255, 0.95); text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.75rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">This Month</p>
                    <p class="h3 fw-bold mb-0" style="color: white; text-shadow: 0 0 35px rgba(255, 255, 255, 0.6), 0 4px 10px rgba(0, 0, 0, 0.3); letter-spacing: -0.5px; font-size: 1.75rem;">₱{{ number_format($monthlyRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="futuristic-card stat-card p-4" style="border: 2px solid rgba(245, 158, 11, 0.5); background: linear-gradient(135deg, #f59e0b, #fbbf24, #f97316); box-shadow: 0 12px 50px rgba(245, 158, 11, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1); border-radius: 20px; backdrop-filter: blur(15px); position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); min-height: 140px;" onmouseover="this.style.transform='translateY(-10px) scale(1.03)'; this.style.boxShadow='0 20px 70px rgba(245, 158, 11, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.25) inset, inset 0 2px 15px rgba(255, 255, 255, 0.15)';" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 12px 50px rgba(245, 158, 11, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1)';">
            <!-- Animated background glow -->
            <div style="position: absolute; top: -40%; right: -25%; width: 220px; height: 220px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%); border-radius: 50%; animation: pulse-glow 4s ease-in-out infinite;"></div>
            <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 1;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.25); border: 3px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.2) rotate(10deg)'; this.style.boxShadow='0 10px 40px rgba(255, 255, 255, 0.4), 0 0 60px rgba(255, 255, 255, 0.3) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset';">
                    <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: white; text-shadow: 0 0 30px rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3); filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.6));"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="small mb-2 fw-bold" style="color: rgba(255, 255, 255, 0.95); text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.75rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Outstanding</p>
                    <p class="h3 fw-bold mb-0" style="color: white; text-shadow: 0 0 35px rgba(255, 255, 255, 0.6), 0 4px 10px rgba(0, 0, 0, 0.3); letter-spacing: -0.5px; font-size: 1.75rem;">₱{{ number_format($outstandingPayments, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="futuristic-card stat-card p-4" style="border: 2px solid rgba(239, 68, 68, 0.5); background: linear-gradient(135deg, #ef4444, #dc2626, #b91c1c); box-shadow: 0 12px 50px rgba(239, 68, 68, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1); border-radius: 20px; backdrop-filter: blur(15px); position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); min-height: 140px;" onmouseover="this.style.transform='translateY(-10px) scale(1.03)'; this.style.boxShadow='0 20px 70px rgba(239, 68, 68, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.25) inset, inset 0 2px 15px rgba(255, 255, 255, 0.15)';" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 12px 50px rgba(239, 68, 68, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1)';">
            <!-- Animated background glow -->
            <div style="position: absolute; top: -40%; right: -25%; width: 220px; height: 220px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%); border-radius: 50%; animation: pulse-glow 4s ease-in-out infinite;"></div>
            <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 1;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.25); border: 3px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.2) rotate(10deg)'; this.style.boxShadow='0 10px 40px rgba(255, 255, 255, 0.4), 0 0 60px rgba(255, 255, 255, 0.3) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset';">
                    <i class="fas fa-clock" style="font-size: 2rem; color: white; text-shadow: 0 0 30px rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3); filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.6));"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="small mb-2 fw-bold" style="color: rgba(255, 255, 255, 0.95); text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.75rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Overdue</p>
                    <p class="h3 fw-bold mb-0" style="color: white; text-shadow: 0 0 35px rgba(255, 255, 255, 0.6), 0 4px 10px rgba(0, 0, 0, 0.3); letter-spacing: -0.5px; font-size: 1.75rem;">₱{{ number_format($overduePayments, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Business Metrics -->
<div class="row g-4 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="futuristic-card stat-card p-4" style="border: 2px solid rgba(0, 102, 255, 0.5); background: linear-gradient(135deg, #0066ff, #3b82f6, #2563eb); box-shadow: 0 12px 50px rgba(0, 102, 255, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1); border-radius: 20px; backdrop-filter: blur(15px); position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); min-height: 140px;" onmouseover="this.style.transform='translateY(-10px) scale(1.03)'; this.style.boxShadow='0 20px 70px rgba(0, 102, 255, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.25) inset, inset 0 2px 15px rgba(255, 255, 255, 0.15)';" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 12px 50px rgba(0, 102, 255, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1)';">
            <!-- Animated background glow -->
            <div style="position: absolute; top: -40%; right: -25%; width: 220px; height: 220px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%); border-radius: 50%; animation: pulse-glow 4s ease-in-out infinite;"></div>
            <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 1;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.25); border: 3px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.2) rotate(10deg)'; this.style.boxShadow='0 10px 40px rgba(255, 255, 255, 0.4), 0 0 60px rgba(255, 255, 255, 0.3) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset';">
                    <i class="fas fa-home" style="font-size: 2rem; color: white; text-shadow: 0 0 30px rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3); filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.6));"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="small mb-2 fw-bold" style="color: rgba(255, 255, 255, 0.95); text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.75rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Total Bookings</p>
                    <p class="h3 fw-bold mb-0" style="color: white; text-shadow: 0 0 35px rgba(255, 255, 255, 0.6), 0 4px 10px rgba(0, 0, 0, 0.3); letter-spacing: -0.5px; font-size: 1.75rem;">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="futuristic-card stat-card p-4" style="border: 2px solid rgba(34, 197, 94, 0.5); background: linear-gradient(135deg, #22c55e, #16a34a, #15803d); box-shadow: 0 12px 50px rgba(34, 197, 94, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1); border-radius: 20px; backdrop-filter: blur(15px); position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); min-height: 140px;" onmouseover="this.style.transform='translateY(-10px) scale(1.03)'; this.style.boxShadow='0 20px 70px rgba(34, 197, 94, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.25) inset, inset 0 2px 15px rgba(255, 255, 255, 0.15)';" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 12px 50px rgba(34, 197, 94, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1)';">
            <!-- Animated background glow -->
            <div style="position: absolute; top: -40%; right: -25%; width: 220px; height: 220px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%); border-radius: 50%; animation: pulse-glow 4s ease-in-out infinite;"></div>
            <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 1;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.25); border: 3px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.2) rotate(10deg)'; this.style.boxShadow='0 10px 40px rgba(255, 255, 255, 0.4), 0 0 60px rgba(255, 255, 255, 0.3) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset';">
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: white; text-shadow: 0 0 30px rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3); filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.6));"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="small mb-2 fw-bold" style="color: rgba(255, 255, 255, 0.95); text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.75rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Confirmed</p>
                    <p class="h3 fw-bold mb-0" style="color: white; text-shadow: 0 0 35px rgba(255, 255, 255, 0.6), 0 4px 10px rgba(0, 0, 0, 0.3); letter-spacing: -0.5px; font-size: 1.75rem;">{{ $confirmedBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="futuristic-card stat-card p-4" style="border: 2px solid rgba(124, 58, 237, 0.5); background: linear-gradient(135deg, #7c3aed, #8b5cf6, #6d28d9); box-shadow: 0 12px 50px rgba(124, 58, 237, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1); border-radius: 20px; backdrop-filter: blur(15px); position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); min-height: 140px;" onmouseover="this.style.transform='translateY(-10px) scale(1.03)'; this.style.boxShadow='0 20px 70px rgba(124, 58, 237, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.25) inset, inset 0 2px 15px rgba(255, 255, 255, 0.15)';" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 12px 50px rgba(124, 58, 237, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.2) inset, inset 0 2px 10px rgba(255, 255, 255, 0.1)';">
            <!-- Animated background glow -->
            <div style="position: absolute; top: -40%; right: -25%; width: 220px; height: 220px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent 70%); border-radius: 50%; animation: pulse-glow 4s ease-in-out infinite;"></div>
            <div class="d-flex align-items-center gap-3" style="position: relative; z-index: 1;">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.25); border: 3px solid rgba(255, 255, 255, 0.5); box-shadow: 0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);" onmouseover="this.style.transform='scale(1.2) rotate(10deg)'; this.style.boxShadow='0 10px 40px rgba(255, 255, 255, 0.4), 0 0 60px rgba(255, 255, 255, 0.3) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 8px 35px rgba(255, 255, 255, 0.3), 0 0 50px rgba(255, 255, 255, 0.2) inset';">
                    <i class="fas fa-users" style="font-size: 2rem; color: white; text-shadow: 0 0 30px rgba(255, 255, 255, 0.8), 0 2px 4px rgba(0, 0, 0, 0.3); filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.6));"></i>
                </div>
                <div class="flex-grow-1">
                    <p class="small mb-2 fw-bold" style="color: rgba(255, 255, 255, 0.95); text-transform: uppercase; letter-spacing: 1.5px; font-size: 0.75rem; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">Active Tenants</p>
                    <p class="h3 fw-bold mb-0" style="color: white; text-shadow: 0 0 35px rgba(255, 255, 255, 0.6), 0 4px 10px rgba(0, 0, 0, 0.3); letter-spacing: -0.5px; font-size: 1.75rem;">{{ $activeTenants }}/{{ $totalTenants }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="futuristic-card mb-4" style="border: 2px solid rgba(0, 102, 255, 0.3); background: white; box-shadow: 0 8px 32px rgba(0, 102, 255, 0.15), 0 0 0 1px rgba(0, 102, 255, 0.1) inset; border-radius: 16px; overflow: hidden;">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white;">
        <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Monthly Revenue Trend</h3>
        <p class="small mb-0" style="color: #0066ff; font-weight: 500;">Revenue performance over the last 12 months.</p>
    </div>
    <div class="p-4" style="background: white;">
        <div class="d-flex align-items-end gap-2" style="height: 280px;">
            @foreach($monthlyRevenueData as $data)
            <div class="flex-fill d-flex flex-column align-items-center" style="transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.08)';" onmouseout="this.style.transform='scale(1)';">
                <div class="w-100 rounded-top" 
                     style="background: linear-gradient(180deg, #0066ff, #3b82f6, #2563eb); 
                            height: {{ $data['revenue'] > 0 ? max(20, ($data['revenue'] / max(array_column($monthlyRevenueData, 'revenue'))) * 220) : 5 }}px;
                            min-height: 5px; box-shadow: 0 6px 20px rgba(0, 102, 255, 0.35), 0 0 25px rgba(0, 102, 255, 0.25) inset; transition: all 0.3s ease; border-top-left-radius: 8px; border-top-right-radius: 8px;" 
                     onmouseover="this.style.boxShadow='0 8px 28px rgba(0, 102, 255, 0.45), 0 0 35px rgba(0, 102, 255, 0.35) inset';" 
                     onmouseout="this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.35), 0 0 25px rgba(0, 102, 255, 0.25) inset';"></div>
                <div class="small mt-2 fw-semibold" style="color: #0066ff; transform: rotate(-45deg); white-space: nowrap; font-size: 0.7rem;">{{ $data['month'] }}</div>
                <div class="small mt-1 fw-bold" style="color: #0066ff;">₱{{ number_format($data['revenue'], 0) }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Payment Method Breakdown -->
<div class="futuristic-card mb-4" style="border: 2px solid rgba(0, 102, 255, 0.3); background: white; box-shadow: 0 8px 32px rgba(0, 102, 255, 0.15), 0 0 0 1px rgba(0, 102, 255, 0.1) inset; border-radius: 16px; overflow: hidden;">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white;">
        <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Payment Methods</h3>
        <p class="small mb-0" style="color: #0066ff; font-weight: 500;">Revenue breakdown by payment method.</p>
    </div>
    <div class="p-4" style="background: white;">
        <div class="row g-3">
            @foreach($paymentMethodBreakdown as $method)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="futuristic-card p-4" style="border: 2px solid rgba(0, 102, 255, 0.3); background: white; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.15); border-radius: 12px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(0, 102, 255, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.15)';">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="small fw-semibold mb-2" style="color: #0066ff; text-transform: uppercase; letter-spacing: 0.8px; font-size: 0.75rem;">{{ ucfirst(str_replace('_', ' ', $method->method)) }}</h4>
                            <p class="h4 fw-bold mb-0" style="color: #0066ff;">₱{{ number_format($method->total_amount, 2) }}</p>
                        </div>
                        <div class="text-end">
                            <p class="small mb-0 fw-semibold" style="color: #0066ff;">{{ $method->count }} transactions</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="futuristic-card" style="border: 2px solid rgba(0, 102, 255, 0.3); background: white; box-shadow: 0 8px 32px rgba(0, 102, 255, 0.15), 0 0 0 1px rgba(0, 102, 255, 0.1) inset; border-radius: 16px; overflow: hidden;">
    <div class="p-4 border-bottom" style="border-color: rgba(0, 102, 255, 0.2) !important; background: white;">
        <h3 class="h5 fw-bold mb-1" style="color: #0066ff;">Recent Transactions</h3>
        <p class="small mb-0" style="color: #0066ff; font-weight: 500;">Latest payment transactions.</p>
    </div>
    <div class="table-responsive" style="background: white;">
        <table class="table table-hover mb-0">
            <thead style="background: rgba(0, 102, 255, 0.1); border-bottom: 2px solid rgba(0, 102, 255, 0.3);">
                <tr>
                    <th class="text-uppercase small fw-bold py-3 px-4" style="color: #0066ff; letter-spacing: 0.8px;">Tenant</th>
                    <th class="text-uppercase small fw-bold py-3 px-4" style="color: #0066ff; letter-spacing: 0.8px;">Amount</th>
                    <th class="text-uppercase small fw-bold py-3 px-4" style="color: #0066ff; letter-spacing: 0.8px;">Method</th>
                    <th class="text-uppercase small fw-bold py-3 px-4" style="color: #0066ff; letter-spacing: 0.8px;">Status</th>
                    <th class="text-uppercase small fw-bold py-3 px-4" style="color: #0066ff; letter-spacing: 0.8px;">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentTransactions as $transaction)
                <tr style="transition: all 0.3s ease; border-bottom: 1px solid rgba(0, 102, 255, 0.1);" onmouseover="this.style.background='rgba(0, 102, 255, 0.05)'; this.style.transform='scale(1.01)';" onmouseout="this.style.background='white'; this.style.transform='scale(1)';">
                    <td class="fw-semibold py-3 px-4" style="color: #0066ff; vertical-align: middle;">
                        {{ $transaction->tenant->name ?? 'N/A' }}
                    </td>
                    <td class="fw-bold py-3 px-4" style="color: #0066ff; vertical-align: middle; font-size: 1.05rem;">
                        ₱{{ number_format($transaction->amount, 2) }}
                    </td>
                    <td class="py-3 px-4" style="color: #0066ff; font-weight: 500; vertical-align: middle;">
                        {{ ucfirst(str_replace('_', ' ', $transaction->method)) }}
                    </td>
                    <td class="py-3 px-4" style="vertical-align: middle;">
                        <span class="badge px-3 py-2 rounded-pill" 
                              style="@if($transaction->status == 'completed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.35), rgba(34, 197, 94, 0.25)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.25), 0 0 20px rgba(34, 197, 94, 0.15) inset;
                              @elseif($transaction->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.35), rgba(245, 158, 11, 0.25)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25), 0 0 20px rgba(245, 158, 11, 0.15) inset;
                              @elseif($transaction->status == 'failed') background: linear-gradient(135deg, rgba(239, 68, 68, 0.35), rgba(239, 68, 68, 0.25)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.25), 0 0 20px rgba(239, 68, 68, 0.15) inset;
                              @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.35), rgba(148, 163, 184, 0.25)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; box-shadow: 0 4px 15px rgba(148, 163, 184, 0.25), 0 0 20px rgba(148, 163, 184, 0.15) inset; @endif font-weight: 600;">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4" style="color: #0066ff; font-weight: 500; vertical-align: middle;">
                        {{ $transaction->payment_date ? $transaction->payment_date->format('M j, Y') : 'N/A' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
@keyframes pulse-glow {
    0%, 100% {
        opacity: 0.4;
        transform: scale(1);
    }
    50% {
        opacity: 0.7;
        transform: scale(1.15);
    }
}
</style>
@endsection
