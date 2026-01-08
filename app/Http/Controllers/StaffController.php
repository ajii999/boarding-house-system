<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Task;
use App\Models\MaintenanceRequest;
use App\Models\TaskNotification;
use App\Models\Notification;

class StaffController extends Controller
{
    public function dashboard()
    {
        $staffId = session('user_id');
        
        $assignedTasks = Task::where('staff_id', $staffId)->count();
        $completedTasks = Task::where('staff_id', $staffId)
            ->where('status', 'completed')
            ->count();
            
        $maintenanceRequests = MaintenanceRequest::count();
        
        $unreadNotifications = TaskNotification::where('staff_id', $staffId)
            ->where('status', 'unread')
            ->count();
            
        $recentTasks = Task::where('staff_id', $staffId)
            ->latest()
            ->limit(5)
            ->get();
            
        $recentMaintenance = MaintenanceRequest::with('tenant')
            ->latest()
            ->limit(5)
            ->get();

        return view('staff.dashboard', compact(
            'assignedTasks',
            'completedTasks',
            'maintenanceRequests',
            'unreadNotifications',
            'recentTasks',
            'recentMaintenance'
        ));
    }

    public function tasks()
    {
        $staffId = session('user_id');
        
        // Get maintenance requests assigned to this staff member
        $maintenanceRequests = MaintenanceRequest::where('assigned_staff_id', $staffId)
            ->whereNotNull('assigned_staff_id')
            ->with(['tenant', 'room'])
            ->latest('assigned_at')
            ->paginate(10);
            
        return view('staff.tasks', ['tasks' => $maintenanceRequests]);
    }

    public function updateTask(Request $request, $maintenance)
    {
        // Handle route model binding - if it's not already a model, resolve it
        if (!$maintenance instanceof MaintenanceRequest) {
            $maintenance = MaintenanceRequest::where('request_id', $maintenance)
                ->where('assigned_staff_id', session('user_id'))
                ->first();
            if (!$maintenance) {
                abort(404, 'Maintenance request not found or you do not have access to it.');
            }
        }
        
        // Ensure the maintenance request is assigned to the current staff member
        if ($maintenance->assigned_staff_id != session('user_id')) {
            abort(403, 'Unauthorized access to maintenance request.');
        }
        
        $request->validate([
            'status' => 'required|in:assigned,in_progress,completed,closed',
            'notes' => 'nullable|string|max:1000',
        ]);

        $updateData = [
            'status' => $request->status,
        ];
        
        // Update admin_notes if provided
        if ($request->has('notes') && $request->notes) {
            $updateData['admin_notes'] = $request->notes;
        }
        
        // Set timestamps based on status
        if ($request->status === 'in_progress' && !$maintenance->started_at) {
            $updateData['started_at'] = now();
        } elseif ($request->status === 'completed' && !$maintenance->completed_at) {
            $updateData['completed_at'] = now();
        }

        $maintenance->update($updateData);

        return redirect()->route('staff.tasks')->with('success', 'Task updated successfully.');
    }

    public function maintenance()
    {
        $staffId = session('user_id');
        
        $maintenanceRequests = MaintenanceRequest::where('assigned_staff_id', $staffId)
            ->with(['tenant', 'room'])
            ->latest()
            ->paginate(10);
            
        return view('staff.maintenance', compact('maintenanceRequests'));
    }

    public function showMaintenance(MaintenanceRequest $maintenance)
    {
        // Ensure the maintenance request is assigned to the current staff member
        if ($maintenance->assigned_staff_id != session('user_id')) {
            abort(403, 'Unauthorized access to maintenance request.');
        }
        
        $maintenance->load(['tenant', 'room']);
        
        return view('staff.maintenance.show', compact('maintenance'));
    }

    public function notifications()
    {
        $staffId = session('user_id');
        
        // Get notifications for this staff member (polymorphic relationship)
        $notifications = Notification::where('notifiable_type', 'App\Models\Staff')
            ->where('notifiable_id', $staffId)
            ->latest()
            ->paginate(10);
            
        return view('staff.notifications', compact('notifications'));
    }

    public function markNotificationAsRead(Notification $notification)
    {
        // Route model binding ensures the notification belongs to the current staff member
        // Additional check for safety
        if ($notification->notifiable_type !== 'App\Models\Staff' || 
            $notification->notifiable_id != session('user_id')) {
            return back()->with('error', 'Unauthorized access to notification.');
        }

        $notification->update([
            'status' => 'read',
            'read_at' => now()
        ]);

        return back()->with('success', 'Notification marked as read.');
    }
}
