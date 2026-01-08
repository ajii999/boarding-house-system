@extends('layouts.admin')

@section('title', 'Booking Management')
@section('page-title', 'Booking Management')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 8px 32px rgba(0, 102, 255, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px; position: relative; overflow: hidden;">
    <!-- Animated background glow -->
    <div style="position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent); border-radius: 50%; animation: pulse 4s ease-in-out infinite;"></div>
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3" style="position: relative; z-index: 1;">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'; this.style.background='rgba(255, 255, 255, 0.35)'; this.style.boxShadow='0 6px 20px rgba(255, 255, 255, 0.3)';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(255, 255, 255, 0.25)'; this.style.boxShadow='0 4px 15px rgba(255, 255, 255, 0.2)';">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: white; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); letter-spacing: -0.5px;">Booking Management</h1>
                <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.9); font-weight: 500;">Manage all bookings in your boarding house</p>
            </div>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="btn d-flex align-items-center" style="background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 12px; transition: all 0.3s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-2px)'; this.style.background='rgba(255, 255, 255, 0.35)'; this.style.boxShadow='0 6px 25px rgba(255, 255, 255, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(255, 255, 255, 0.2)';">
            <i class="fas fa-plus me-2"></i>Create New Booking
        </a>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="futuristic-card p-4 mb-4" style="border: 2px solid rgba(0, 102, 255, 0.3); background: linear-gradient(135deg, #0066ff, #3b82f6, #7c3aed); box-shadow: 0 4px 20px rgba(0, 102, 255, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 12px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <h3 class="h5 fw-bold mb-0" style="color: white; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">All Bookings</h3>
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="d-flex flex-column flex-md-row align-items-end gap-3">
            <div class="w-100" style="max-width: 400px;">
                <label for="search" class="form-label small fw-semibold" style="color: white;">Search</label>
                <div class="position-relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search bookings..." 
                           class="form-control" style="background: white; border: 2px solid rgba(255, 255, 255, 0.4); border-radius: 10px; padding: 0.75rem 1rem 0.75rem 2.5rem; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);" onfocus="this.style.borderColor='white'; this.style.boxShadow='0 2px 12px rgba(255, 255, 255, 0.3), 0 0 0 3px rgba(255, 255, 255, 0.2)';" onblur="this.style.borderColor='rgba(255, 255, 255, 0.4)'; this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.1)';">
                    <div class="position-absolute top-50 start-0 translate-middle-y ms-3" style="color: #0066ff; line-height: 1;">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-end gap-2">
                <button type="submit" class="btn d-flex align-items-center" style="background: rgba(255, 255, 255, 0.25); border: 2px solid rgba(255, 255, 255, 0.4); color: white; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.background='rgba(255, 255, 255, 0.35)'; this.style.boxShadow='0 6px 20px rgba(255, 255, 255, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.background='rgba(255, 255, 255, 0.25)'; this.style.boxShadow='0 4px 15px rgba(255, 255, 255, 0.2)';">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                @if(request('search'))
                <a href="{{ route('admin.bookings.index') }}" class="btn d-flex align-items-center" style="background: rgba(255, 255, 255, 0.15); border: 2px solid rgba(255, 255, 255, 0.3); color: white; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(255, 255, 255, 0.1);" onmouseover="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.borderColor='rgba(255, 255, 255, 0.4)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.borderColor='rgba(255, 255, 255, 0.3)'; this.style.transform='translateY(0)';">
                    <i class="fas fa-times me-1"></i>Clear
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="futuristic-card" style="border: 1px solid rgba(0, 102, 255, 0.25); background: linear-gradient(135deg, rgba(0, 102, 255, 0.05), rgba(124, 58, 237, 0.03)); box-shadow: 0 4px 20px rgba(0, 102, 255, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.05) inset; border-radius: 12px; backdrop-filter: blur(8px); overflow: hidden;">
    <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
        <table class="table table-hover mb-0" style="font-size: 0.875rem; width: 100%;">
            <thead style="background: linear-gradient(135deg, rgba(0, 102, 255, 0.12), rgba(124, 58, 237, 0.08)); border-bottom: 2px solid rgba(0, 102, 255, 0.3);">
                <tr>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">#</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Tenant</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Room</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Check In</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Check Out</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Amount</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Payment</th>
                    <th class="text-uppercase small fw-bold py-2 px-2" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Status</th>
                    <th class="text-uppercase small fw-bold py-2 px-2 text-center" style="color: #0066ff; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px; white-space: nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr style="transition: all 0.3s ease; border-bottom: 1px solid rgba(0, 102, 255, 0.1);" onmouseover="this.style.background='rgba(0, 102, 255, 0.05)'; this.style.transform='scale(1.01)';" onmouseout="this.style.background='transparent'; this.style.transform='scale(1)';">
                    <td class="py-2 px-2 fw-semibold" style="color: #0066ff; text-shadow: 0 0 8px rgba(0, 102, 255, 0.3); vertical-align: middle; white-space: nowrap; font-size: 0.85rem;">
                        #{{ $booking->booking_id }}
                    </td>
                    <td class="py-2 px-2" style="vertical-align: middle;">
                        <div class="d-flex align-items-center gap-1">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                 style="width: 32px; height: 32px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.2), rgba(124, 58, 237, 0.15)); border: 2px solid rgba(0, 102, 255, 0.4); box-shadow: 0 4px 15px rgba(0, 102, 255, 0.2), 0 0 20px rgba(0, 102, 255, 0.1) inset; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1) rotate(5deg)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.3), 0 0 30px rgba(0, 102, 255, 0.2) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.2), 0 0 20px rgba(0, 102, 255, 0.1) inset';">
                                <i class="fas fa-user" style="color: #0066ff; text-shadow: 0 0 10px rgba(0, 102, 255, 0.5); font-size: 0.75rem;"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="fw-semibold" style="color: var(--text-primary); font-size: 0.8rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px;">{{ $booking->tenant->name ?? 'N/A' }}</div>
                                <div class="small" style="color: rgba(0, 102, 255, 0.7); font-size: 0.7rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px;">{{ $booking->tenant->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-2 px-2" style="vertical-align: middle;">
                        <div class="fw-semibold" style="color: var(--text-primary); font-size: 0.8rem;">Room {{ $booking->room->room_number ?? 'N/A' }}</div>
                        <div class="small" style="color: rgba(0, 102, 255, 0.7); font-size: 0.7rem;">{{ $booking->room->room_type ?? 'N/A' }}</div>
                    </td>
                    <td class="py-2 px-2" style="color: var(--text-primary); font-weight: 500; vertical-align: middle; white-space: nowrap; font-size: 0.8rem;">
                        {{ $booking->check_in ? $booking->check_in->format('M j, Y') : 'N/A' }}
                    </td>
                    <td class="py-2 px-2" style="color: var(--text-primary); font-weight: 500; vertical-align: middle; white-space: nowrap; font-size: 0.8rem;">
                        {{ $booking->check_out ? $booking->check_out->format('M j, Y') : 'N/A' }}
                    </td>
                    <td class="py-2 px-2 fw-bold" style="color: #22c55e; text-shadow: 0 0 10px rgba(34, 197, 94, 0.3); vertical-align: middle; font-size: 0.85rem; white-space: nowrap;">
                        ₱{{ number_format($booking->total_amount, 2) }}
                    </td>
                    <td class="py-2 px-2" style="vertical-align: middle;">
                        @php
                            $totalPaid = $booking->payments()->where('status', 'completed')->sum('amount');
                            $paymentStatus = $totalPaid >= $booking->total_amount ? 'paid' : ($totalPaid > 0 ? 'partial' : 'unpaid');
                        @endphp
                        <div class="d-flex flex-column gap-1">
                            @if($paymentStatus == 'paid')
                                <span class="badge px-2 py-1 rounded-pill" 
                                      style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; box-shadow: 0 2px 10px rgba(34, 197, 94, 0.2), 0 0 15px rgba(34, 197, 94, 0.1) inset; font-weight: 600; font-size: 0.7rem; white-space: nowrap;">
                                    <i class="fas fa-check-circle me-1"></i>Paid
                                </span>
                            @elseif($paymentStatus == 'partial')
                                <span class="badge px-2 py-1 rounded-pill" 
                                      style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.2), 0 0 15px rgba(245, 158, 11, 0.1) inset; font-weight: 600; font-size: 0.7rem; white-space: nowrap;">
                                    <i class="fas fa-clock me-1"></i>Partial
                                </span>
                            @else
                                <span class="badge px-2 py-1 rounded-pill" 
                                      style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.2), 0 0 15px rgba(239, 68, 68, 0.1) inset; font-weight: 600; font-size: 0.7rem; white-space: nowrap;">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Unpaid
                                </span>
                            @endif
                            @if($totalPaid > 0)
                                <span class="small" style="color: rgba(0, 102, 255, 0.8); font-weight: 500; font-size: 0.7rem; white-space: nowrap;">₱{{ number_format($totalPaid, 2) }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="py-2 px-2" style="vertical-align: middle;">
                        <span class="badge px-2 py-1 rounded-pill" 
                              style="@if($booking->status == 'confirmed') background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border: 1px solid rgba(34, 197, 94, 0.5); color: #22c55e; box-shadow: 0 2px 10px rgba(34, 197, 94, 0.2), 0 0 15px rgba(34, 197, 94, 0.1) inset;
                              @elseif($booking->status == 'pending') background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2)); border: 1px solid rgba(245, 158, 11, 0.5); color: #f59e0b; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.2), 0 0 15px rgba(245, 158, 11, 0.1) inset;
                              @elseif($booking->status == 'cancelled') background: linear-gradient(135deg, rgba(239, 68, 68, 0.3), rgba(239, 68, 68, 0.2)); border: 1px solid rgba(239, 68, 68, 0.5); color: #ef4444; box-shadow: 0 2px 10px rgba(239, 68, 68, 0.2), 0 0 15px rgba(239, 68, 68, 0.1) inset;
                              @elseif($booking->status == 'completed') background: linear-gradient(135deg, rgba(0, 102, 255, 0.3), rgba(0, 102, 255, 0.2)); border: 1px solid rgba(0, 102, 255, 0.5); color: #0066ff; box-shadow: 0 2px 10px rgba(0, 102, 255, 0.2), 0 0 15px rgba(0, 102, 255, 0.1) inset;
                              @else background: linear-gradient(135deg, rgba(148, 163, 184, 0.3), rgba(148, 163, 184, 0.2)); border: 1px solid rgba(148, 163, 184, 0.5); color: #94a3b8; box-shadow: 0 2px 10px rgba(148, 163, 184, 0.2), 0 0 15px rgba(148, 163, 184, 0.1) inset; @endif font-weight: 600; font-size: 0.7rem; white-space: nowrap;">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-2 text-center" style="vertical-align: middle;">
                        <div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; color: #0066ff; background: rgba(0, 102, 255, 0.1); border: 1px solid rgba(0, 102, 255, 0.3); box-shadow: 0 2px 8px rgba(0, 102, 255, 0.2); transition: all 0.3s ease; text-decoration: none; font-size: 0.7rem;" title="View Details" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(0, 102, 255, 0.2)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.3), 0 0 20px rgba(0, 102, 255, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(0, 102, 255, 0.1)'; this.style.boxShadow='0 2px 8px rgba(0, 102, 255, 0.2)';">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($booking->status === 'pending')
                                <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" class="d-inline" onsubmit="return confirm('Approve this booking?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; color: #22c55e; background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); box-shadow: 0 2px 8px rgba(34, 197, 94, 0.2); transition: all 0.3s ease; font-size: 0.7rem;" title="Approve Booking" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(34, 197, 94, 0.2)'; this.style.boxShadow='0 4px 15px rgba(34, 197, 94, 0.3), 0 0 20px rgba(34, 197, 94, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(34, 197, 94, 0.1)'; this.style.boxShadow='0 2px 8px rgba(34, 197, 94, 0.2)';">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <button onclick="openDeclineModal({{ $booking->booking_id }})" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2); transition: all 0.3s ease; font-size: 0.7rem;" title="Decline Booking" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(239, 68, 68, 0.2)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3), 0 0 20px rgba(239, 68, 68, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(239, 68, 68, 0.1)'; this.style.boxShadow='0 2px 8px rgba(239, 68, 68, 0.2)';">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; color: #f59e0b; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2); transition: all 0.3s ease; text-decoration: none; font-size: 0.7rem;" title="Edit Booking" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(245, 158, 11, 0.2)'; this.style.boxShadow='0 4px 15px rgba(245, 158, 11, 0.3), 0 0 20px rgba(245, 158, 11, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(245, 158, 11, 0.1)'; this.style.boxShadow='0 2px 8px rgba(245, 158, 11, 0.2)';">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2); transition: all 0.3s ease; font-size: 0.7rem;" title="Delete Booking" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(239, 68, 68, 0.2)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3), 0 0 20px rgba(239, 68, 68, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(239, 68, 68, 0.1)'; this.style.boxShadow='0 2px 8px rgba(239, 68, 68, 0.2)';">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(124, 58, 237, 0.1)); border: 3px solid rgba(0, 102, 255, 0.4); box-shadow: 0 8px 30px rgba(0, 102, 255, 0.2), 0 0 40px rgba(0, 102, 255, 0.1) inset;">
                                <i class="fas fa-calendar-times" style="font-size: 2.5rem; color: #0066ff; text-shadow: 0 0 20px rgba(0, 102, 255, 0.5);"></i>
                            </div>
                            <p class="mb-2" style="color: rgba(0, 102, 255, 0.8); font-weight: 500;">No bookings found.</p>
                            <a href="{{ route('admin.bookings.create') }}" class="btn d-flex align-items-center" style="background: linear-gradient(135deg, #0066ff, #7c3aed); border: none; color: white; box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 102, 255, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 102, 255, 0.3)';">
                                <i class="fas fa-plus me-2"></i>Create the first booking
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($bookings->hasPages())
<div class="mt-4">
    {{ $bookings->links() }}
</div>
@endif

<style>
@keyframes pulse {
    0%, 100% {
        opacity: 0.5;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.1);
    }
}
</style>

<!-- Decline Booking Modal -->
<div class="modal fade" id="declineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content futuristic-card" style="border-color: rgba(239, 68, 68, 0.3);">
            <div class="modal-header border-bottom" style="border-color: rgba(239, 68, 68, 0.2) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(239, 68, 68, 0.1)); border: 2px solid rgba(239, 68, 68, 0.5);">
                        <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
            </div>
                    <h5 class="modal-title fw-bold" style="color: #ef4444;">Decline Booking</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="declineForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p class="small mb-3" style="color: var(--text-secondary);">Please provide a reason for declining this booking request.</p>
                    <textarea name="admin_notes" rows="3" required
                              class="form-control"
                              placeholder="Enter reason for declining..."></textarea>
                </div>
                <div class="modal-footer border-top" style="border-color: rgba(239, 68, 68, 0.2) !important;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none;">
                        Decline Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openDeclineModal(bookingId) {
    document.getElementById('declineForm').action = `/admin/bookings/${bookingId}/decline`;
    const modal = new bootstrap.Modal(document.getElementById('declineModal'));
    modal.show();
}
</script>
@endsection
