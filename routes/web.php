<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StorageController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Storage route for serving images
Route::get('/storage/{path}', [StorageController::class, 'show'])->where('path', '.*')->name('storage.show');

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password/find', [App\Http\Controllers\PasswordResetController::class, 'findAccount'])->name('password.find');
Route::post('/forgot-password/send', [App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'resetPassword'])->name('password.update');

// Admin routes
Route::middleware(['auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    // Custom route binding for maintenance requests - admin can access all requests
    Route::bind('maintenance', function ($value) {
        // Convert to integer if numeric to ensure proper type matching
        $requestId = is_numeric($value) ? (int)$value : $value;
        $maintenance = \App\Models\MaintenanceRequest::where('request_id', $requestId)->first();
        if (!$maintenance) {
            abort(404, 'Maintenance request not found.');
        }
        return $maintenance;
    });
    
    // Custom route binding for notifications - admin can access all notifications
    Route::bind('notification', function ($value) {
        $notificationId = is_numeric($value) ? (int)$value : $value;
        $notification = \App\Models\Notification::where('notification_id', $notificationId)->first();
        if (!$notification) {
            abort(404, 'Notification not found.');
        }
        return $notification;
    });
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('tenants', AdminController::class);
    Route::get('/tenants/{tenant}/active-booking', [AdminController::class, 'getActiveBooking'])->name('tenants.active-booking');
    Route::resource('rooms', RoomController::class);
    Route::resource('bookings', BookingController::class)->except(['show']);
    Route::resource('payments', PaymentController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
    
    // Maintenance routes - explicitly define to ensure route model binding works
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance/{id}', [AdminController::class, 'showMaintenance'])->name('maintenance.show')->where('id', '[0-9]+');
    Route::get('/maintenance/{id}/edit', [MaintenanceController::class, 'edit'])->name('maintenance.edit')->where('id', '[0-9]+');
    Route::match(['put', 'patch'], '/maintenance/{id}', [MaintenanceController::class, 'update'])->name('maintenance.update')->where('id', '[0-9]+');
    Route::delete('/maintenance/{id}', [MaintenanceController::class, 'destroy'])->name('maintenance.destroy')->where('id', '[0-9]+');
    Route::post('/maintenance/{id}/assign', [MaintenanceController::class, 'assignToStaff'])->name('maintenance.assign')->where('id', '[0-9]+');
    Route::post('/maintenance/{id}/close', [MaintenanceController::class, 'closeRequest'])->name('maintenance.close')->where('id', '[0-9]+');
    Route::get('/reports/{report}/download', [ReportController::class, 'download'])->name('reports.download');
    Route::get('/invoices', [AdminController::class, 'invoices'])->name('invoices');
    Route::get('/invoices/create', [AdminController::class, 'createInvoice'])->name('invoices.create');
    Route::post('/invoices', [AdminController::class, 'storeInvoice'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [AdminController::class, 'showInvoice'])->name('invoices.show');
    Route::get('/invoices/{invoice}/edit', [AdminController::class, 'editInvoice'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [AdminController::class, 'updateInvoice'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [AdminController::class, 'destroyInvoice'])->name('invoices.destroy');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [AdminController::class, 'markAsRead'])->name('notifications.read')->where('id', '[0-9]+');
    
    // Booking approval routes
    Route::post('/bookings/{booking}/approve', [AdminController::class, 'approveBooking'])->name('bookings.approve');
    Route::post('/bookings/{booking}/decline', [AdminController::class, 'declineBooking'])->name('bookings.decline');
    Route::get('/bookings/{booking}/show', [AdminController::class, 'showBooking'])->name('bookings.show');
    
    // Payment verification routes
    Route::post('/payments/{payment}/verify', [AdminController::class, 'verifyPayment'])->name('payments.verify');
    Route::post('/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');
    
    // Reports routes
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
    Route::get('/reports/create', [AdminController::class, 'createReport'])->name('reports.create');
    Route::post('/reports', [AdminController::class, 'storeReport'])->name('reports.store');
    Route::get('/reports/{report}', [AdminController::class, 'showReport'])->name('reports.show');
    Route::get('/reports/{report}/edit', [AdminController::class, 'editReport'])->name('reports.edit');
    Route::put('/reports/{report}', [AdminController::class, 'updateReport'])->name('reports.update');
    Route::delete('/reports/{report}', [AdminController::class, 'destroyReport'])->name('reports.destroy');
});

// Tenant routes
Route::middleware(['auth.tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [TenantController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [TenantController::class, 'profile'])->name('profile');
    Route::put('/profile', [TenantController::class, 'updateProfile'])->name('profile.update');
    Route::resource('bookings', BookingController::class);
    Route::get('/payments', [TenantController::class, 'payments'])->name('payments');
    Route::get('/payments/create', [TenantController::class, 'createPayment'])->name('payments.create');
    Route::post('/payments', [TenantController::class, 'storePayment'])->name('payments.store');
    Route::get('/payments/{payment}', [TenantController::class, 'showPayment'])->name('payments.show');
    Route::get('/invoices', [TenantController::class, 'invoices'])->name('invoices');
    Route::post('/bookings/{booking}/reserve-payment', [PaymentMethodController::class, 'reserve'])->name('bookings.reserve-payment');
    Route::post('/payments/{payment}/complete', [PaymentMethodController::class, 'complete'])->name('payments.complete');
    Route::post('/payments/{payment}/cancel', [PaymentMethodController::class, 'cancel'])->name('payments.cancel');
    Route::get('/payment-methods/available', [PaymentMethodController::class, 'getAvailableMethods'])->name('payment-methods.available');
    Route::get('/rooms', [TenantController::class, 'rooms'])->name('rooms');
    Route::post('/rooms/select', [TenantController::class, 'selectRoom'])->name('rooms.select');
    
    // Scoped route model binding for maintenance requests - tenants can only access their own
    Route::bind('maintenance-request', function ($value) {
        $tenantId = session('user_id');
        if (!$tenantId) {
            abort(403, 'Unauthorized access.');
        }
        $maintenance = \App\Models\MaintenanceRequest::where('request_id', $value)
            ->where('tenant_id', $tenantId)
            ->first();
        if (!$maintenance) {
            abort(404, 'Maintenance request not found or you do not have access to it.');
        }
        return $maintenance;
    });
    
    // Define confirm route BEFORE resource routes to ensure it's matched first
    // Use explicit parameter name to avoid route binding conflicts
    Route::post('/maintenance/{id}/confirm', [MaintenanceController::class, 'confirmCompletion'])->name('maintenance.confirm')->where('id', '[0-9]+');
    Route::resource('maintenance-requests', MaintenanceController::class)->names('maintenance');
    
    // Scoped route model binding for notifications - tenants can only access their own
    Route::bind('notification', function ($value) {
        $tenantId = session('user_id');
        if (!$tenantId) {
            abort(403, 'Unauthorized access.');
        }
        $notification = \App\Models\Notification::where('notification_id', $value)
            ->where('notifiable_type', 'App\Models\Tenant')
            ->where('notifiable_id', $tenantId)
            ->first();
        if (!$notification) {
            abort(404, 'Notification not found or you do not have access to it.');
        }
        return $notification;
    });
    
    Route::get('/notifications', [TenantController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/mark-read', [TenantController::class, 'markNotificationAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [TenantController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');
});

// Staff routes
Route::middleware(['auth.staff'])->prefix('staff')->name('staff.')->group(function () {
    // Custom route binding for maintenance requests - staff can only access assigned requests
    Route::bind('maintenance', function ($value) {
        $staffId = session('user_id');
        if (!$staffId) {
            abort(403, 'Unauthorized access.');
        }
        $maintenance = \App\Models\MaintenanceRequest::where('request_id', $value)
            ->where('assigned_staff_id', $staffId)
            ->first();
        if (!$maintenance) {
            abort(404, 'Maintenance request not found or you do not have access to it.');
        }
        return $maintenance;
    });
    
    // Custom route binding for notifications - staff can only access their own notifications
    Route::bind('notification', function ($value) {
        $staffId = session('user_id');
        if (!$staffId) {
            abort(403, 'Unauthorized access.');
        }
        $notification = \App\Models\Notification::where('notification_id', $value)
            ->where('notifiable_type', 'App\Models\Staff')
            ->where('notifiable_id', $staffId)
            ->first();
        if (!$notification) {
            abort(404, 'Notification not found or you do not have access to it.');
        }
        return $notification;
    });
    
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/tasks', [StaffController::class, 'tasks'])->name('tasks');
    Route::put('/tasks/{maintenance}', [StaffController::class, 'updateTask'])->name('tasks.update');
    Route::get('/maintenance', [StaffController::class, 'maintenance'])->name('maintenance');
    Route::get('/maintenance/{maintenance}', [StaffController::class, 'showMaintenance'])->name('maintenance.show');
    Route::post('/maintenance/{maintenance}/start', [MaintenanceController::class, 'markInProgress'])->name('maintenance.start');
    Route::post('/maintenance/{maintenance}/complete', [MaintenanceController::class, 'completeRequest'])->name('maintenance.complete');
    Route::get('/notifications', [StaffController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/mark-read', [StaffController::class, 'markNotificationAsRead'])->name('notifications.mark-read');
});
