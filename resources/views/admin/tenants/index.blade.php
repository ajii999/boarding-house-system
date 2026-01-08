@extends('layouts.admin')

@section('title', 'Tenant Management')
@section('page-title', 'Tenant Management')

@section('content')
<!-- Futuristic Header Section -->
<div class="mb-4 mb-md-5 futuristic-card p-4 p-md-5" style="border: 1px solid rgba(14, 165, 233, 0.3); background: linear-gradient(135deg, rgba(14, 165, 233, 0.12), rgba(59, 130, 246, 0.08), rgba(125, 211, 252, 0.06)); box-shadow: 0 8px 32px rgba(14, 165, 233, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.1) inset; border-radius: 16px; backdrop-filter: blur(10px); position: relative; overflow: hidden;">
    <!-- Animated background glow -->
    <div style="position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(14, 165, 233, 0.2), transparent); border-radius: 50%; animation: pulse 4s ease-in-out infinite;"></div>
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3" style="position: relative; z-index: 1;">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(14, 165, 233, 0.2), rgba(59, 130, 246, 0.15)); border: 2px solid rgba(14, 165, 233, 0.4); color: #0ea5e9; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3), 0 0 20px rgba(14, 165, 233, 0.2) inset; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 20px rgba(14, 165, 233, 0.4), 0 0 30px rgba(14, 165, 233, 0.3) inset';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(14, 165, 233, 0.3), 0 0 20px rgba(14, 165, 233, 0.2) inset';">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 h4-md fw-bold mb-1" style="color: #0ea5e9; text-shadow: 0 0 20px rgba(14, 165, 233, 0.3), 0 2px 4px rgba(0, 0, 0, 0.1); letter-spacing: -0.5px;">Tenant Management</h1>
                <p class="mb-0 small" style="color: rgba(14, 165, 233, 0.8); font-weight: 500; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">Manage all tenants in your boarding house</p>
            </div>
        </div>
        <a href="{{ route('admin.tenants.create') }}" class="btn d-flex align-items-center" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; color: white; box-shadow: 0 4px 20px rgba(14, 165, 233, 0.4), 0 0 30px rgba(14, 165, 233, 0.2) inset; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 12px; transition: all 0.3s ease; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 25px rgba(14, 165, 233, 0.5), 0 0 40px rgba(14, 165, 233, 0.3) inset';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(14, 165, 233, 0.4), 0 0 30px rgba(14, 165, 233, 0.2) inset';">
            <i class="fas fa-plus me-2"></i>Add New Tenant
        </a>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="futuristic-card p-4 mb-4" style="border: 1px solid rgba(14, 165, 233, 0.25); background: linear-gradient(135deg, rgba(14, 165, 233, 0.08), rgba(59, 130, 246, 0.05)); box-shadow: 0 4px 20px rgba(14, 165, 233, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.05) inset; border-radius: 12px; backdrop-filter: blur(8px);">
    <form method="GET" action="{{ route('admin.tenants.index') }}" class="d-flex flex-column flex-md-row justify-content-end align-items-end gap-3">
        <div class="w-100" style="max-width: 400px;">
            <label for="search" class="form-label small fw-semibold" style="color: #0ea5e9; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">Search</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                   placeholder="Search by name, email, contact..." 
                   class="form-control" style="background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(14, 165, 233, 0.3); border-radius: 10px; padding: 0.75rem 1rem; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1) inset;" onfocus="this.style.borderColor='rgba(14, 165, 233, 0.6)'; this.style.boxShadow='0 2px 12px rgba(14, 165, 233, 0.2) inset, 0 0 0 3px rgba(14, 165, 233, 0.1)';" onblur="this.style.borderColor='rgba(14, 165, 233, 0.3)'; this.style.boxShadow='0 2px 8px rgba(14, 165, 233, 0.1) inset';">
        </div>
        <div class="d-flex align-items-end gap-2">
            <button type="submit" class="btn d-flex align-items-center" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; color: white; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(14, 165, 233, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(14, 165, 233, 0.3)';">
                <i class="fas fa-search me-1"></i>Search
            </button>
            <a href="{{ route('admin.tenants.index') }}" class="btn d-flex align-items-center" style="background: rgba(14, 165, 233, 0.1); border: 1px solid rgba(14, 165, 233, 0.3); color: #0ea5e9; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1);" onmouseover="this.style.background='rgba(14, 165, 233, 0.15)'; this.style.borderColor='rgba(14, 165, 233, 0.4)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='rgba(14, 165, 233, 0.1)'; this.style.borderColor='rgba(14, 165, 233, 0.3)'; this.style.transform='translateY(0)';">
                <i class="fas fa-times me-1"></i>Clear
            </a>
        </div>
    </form>
</div>

<!-- Tenants Table -->
<div class="futuristic-card" style="border: 1px solid rgba(14, 165, 233, 0.25); background: linear-gradient(135deg, rgba(14, 165, 233, 0.05), rgba(59, 130, 246, 0.03)); box-shadow: 0 4px 20px rgba(14, 165, 233, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.05) inset; border-radius: 12px; backdrop-filter: blur(8px); overflow: hidden;">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead style="background: linear-gradient(135deg, rgba(14, 165, 233, 0.12), rgba(59, 130, 246, 0.08)); border-bottom: 2px solid rgba(14, 165, 233, 0.3);">
                <tr>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0ea5e9; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Tenant</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0ea5e9; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Contact</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0ea5e9; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Current Room</th>
                    <th class="text-uppercase small fw-bold py-3" style="color: #0ea5e9; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Member Since</th>
                    <th class="text-uppercase small fw-bold py-3 text-center" style="color: #0ea5e9; vertical-align: middle; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); letter-spacing: 0.5px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr style="transition: all 0.3s ease; border-bottom: 1px solid rgba(14, 165, 233, 0.1);" onmouseover="this.style.background='rgba(14, 165, 233, 0.05)'; this.style.transform='scale(1.01)';" onmouseout="this.style.background='transparent'; this.style.transform='scale(1)';">
                    <td class="py-3" style="vertical-align: middle;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, rgba(14, 165, 233, 0.2), rgba(59, 130, 246, 0.15)); border: 2px solid rgba(14, 165, 233, 0.4); box-shadow: 0 4px 15px rgba(14, 165, 233, 0.2), 0 0 20px rgba(14, 165, 233, 0.1) inset; transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.1) rotate(5deg)'; this.style.boxShadow='0 6px 20px rgba(14, 165, 233, 0.3), 0 0 30px rgba(14, 165, 233, 0.2) inset';" onmouseout="this.style.transform='scale(1) rotate(0deg)'; this.style.boxShadow='0 4px 15px rgba(14, 165, 233, 0.2), 0 0 20px rgba(14, 165, 233, 0.1) inset';">
                                <i class="fas fa-user" style="color: #0ea5e9; font-size: 0.9rem; text-shadow: 0 0 10px rgba(14, 165, 233, 0.5);"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <div class="fw-semibold" style="color: var(--text-primary); font-size: 0.95rem;">{{ $tenant->name }}</div>
                                <div class="small" style="color: rgba(14, 165, 233, 0.7); font-size: 0.8rem;">{{ $tenant->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3" style="color: var(--text-primary); font-weight: 500; vertical-align: middle;">
                        {{ $tenant->contact_number }}
                    </td>
                    <td class="py-3" style="vertical-align: middle;">
                        @if($tenant->bookings->whereIn('status', ['confirmed', 'completed'])->count() > 0)
                            @php
                                $currentBooking = $tenant->bookings->whereIn('status', ['confirmed', 'completed'])->first();
                            @endphp
                            <span class="badge px-3 py-2 rounded-pill d-inline-block" 
                                  style="background: linear-gradient(135deg, rgba(14, 165, 233, 0.2), rgba(59, 130, 246, 0.15)); border: 1px solid rgba(14, 165, 233, 0.4); color: #0ea5e9; font-weight: 600; box-shadow: 0 2px 10px rgba(14, 165, 233, 0.2), 0 0 15px rgba(14, 165, 233, 0.1) inset;">
                                Room {{ $currentBooking->room->room_number ?? 'N/A' }}
                            </span>
                        @else
                            <span class="small" style="color: rgba(14, 165, 233, 0.6);">No room assigned</span>
                        @endif
                    </td>
                    <td class="py-3" style="color: var(--text-primary); font-weight: 500; vertical-align: middle;">
                        {{ $tenant->created_at->format('M j, Y') }}
                    </td>
                    <td class="py-3 text-center" style="vertical-align: middle;">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <a href="{{ route('admin.tenants.show', $tenant) }}" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; color: #0ea5e9; background: rgba(14, 165, 233, 0.1); border: 1px solid rgba(14, 165, 233, 0.3); box-shadow: 0 2px 8px rgba(14, 165, 233, 0.2); transition: all 0.3s ease; text-decoration: none;" title="View Details" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(14, 165, 233, 0.2)'; this.style.boxShadow='0 4px 15px rgba(14, 165, 233, 0.3), 0 0 20px rgba(14, 165, 233, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(14, 165, 233, 0.1)'; this.style.boxShadow='0 2px 8px rgba(14, 165, 233, 0.2)';">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.tenants.edit', $tenant) }}" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; color: #f59e0b; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2); transition: all 0.3s ease; text-decoration: none;" title="Edit Tenant" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(245, 158, 11, 0.2)'; this.style.boxShadow='0 4px 15px rgba(245, 158, 11, 0.3), 0 0 20px rgba(245, 158, 11, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(245, 158, 11, 0.1)'; this.style.boxShadow='0 2px 8px rgba(245, 158, 11, 0.2)';">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.tenants.destroy', $tenant) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this tenant?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; color: #ef4444; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2); transition: all 0.3s ease;" title="Delete Tenant" onmouseover="this.style.transform='scale(1.15)'; this.style.background='rgba(239, 68, 68, 0.2)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3), 0 0 20px rgba(239, 68, 68, 0.2) inset';" onmouseout="this.style.transform='scale(1)'; this.style.background='rgba(239, 68, 68, 0.1)'; this.style.boxShadow='0 2px 8px rgba(239, 68, 68, 0.2)';">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" 
                                 style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(14, 165, 233, 0.15), rgba(59, 130, 246, 0.1)); border: 3px solid rgba(14, 165, 233, 0.4); box-shadow: 0 8px 30px rgba(14, 165, 233, 0.2), 0 0 40px rgba(14, 165, 233, 0.1) inset;">
                                <i class="fas fa-users" style="font-size: 2.5rem; color: #0ea5e9; text-shadow: 0 0 20px rgba(14, 165, 233, 0.5);"></i>
                            </div>
                            <p class="mb-2" style="color: rgba(14, 165, 233, 0.8); font-weight: 500;">No tenants found.</p>
                            <a href="{{ route('admin.tenants.create') }}" class="btn btn-sm d-flex align-items-center" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8); border: none; color: white; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3); font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 10px; transition: all 0.3s ease; text-decoration: none;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(14, 165, 233, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(14, 165, 233, 0.3)';">
                                <i class="fas fa-plus me-2"></i>Add the first tenant
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($tenants->hasPages())
<div class="mt-4">
    {{ $tenants->links() }}
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
@endsection
