<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceRequest;
use App\Models\Tenant;
use App\Models\Room;

class MaintenanceController extends Controller
{
    /**
     * Resolve maintenance request from route parameter
     */
    private function resolveMaintenance($maintenance)
    {
        if (!$maintenance instanceof MaintenanceRequest) {
            $maintenance = MaintenanceRequest::where('request_id', $maintenance)->first();
            if (!$maintenance) {
                abort(404, 'Maintenance request not found.');
            }
        }
        return $maintenance;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            $query = MaintenanceRequest::where('tenant_id', session('user_id'))
                ->with(['room']);
                
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('issue_type', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('priority', 'like', "%{$search}%")
                      ->orWhereHas('room', function($roomQuery) use ($search) {
                          $roomQuery->where('room_number', 'like', "%{$search}%");
                      });
                });
            }
            
            $maintenanceRequests = $query->latest('request_date')->paginate(10);
            
            return view('tenant.maintenance.index', compact('maintenanceRequests', 'search'));
        }
        
        // Admin view - Get ALL maintenance requests
        $query = MaintenanceRequest::with(['tenant', 'room', 'assignedStaff']);
        
        // Apply search filter if provided
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('issue_type', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('priority', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('tenant', function($tenantQuery) use ($search) {
                      $tenantQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('room', function($roomQuery) use ($search) {
                      $roomQuery->where('room_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('assignedStaff', function($staffQuery) use ($search) {
                      $staffQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Get all requests ordered by most recent first
        $maintenanceRequests = $query->latest('request_date')->paginate(10);
        
        return view('admin.maintenance.index', compact('maintenanceRequests', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            $rooms = Room::all();
            return view('tenant.maintenance.create', compact('rooms'));
        }
        
        // Admin view
        $tenants = Tenant::all();
        $rooms = Room::all();
        
        return view('admin.maintenance.create', compact('tenants', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if this is a tenant request
        if (request()->routeIs('tenant.*')) {
            $request->validate([
                'room_id' => 'nullable|exists:rooms,room_id',
                'issue_type' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'request_date' => 'required|date',
                'priority' => 'required|in:low,medium,high,urgent',
                'tenant_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = [
                'tenant_id' => session('user_id'),
                'room_id' => $request->room_id,
                'issue_type' => $request->issue_type,
                'description' => $request->description,
                'request_date' => $request->request_date,
                'priority' => $request->priority,
                'status' => 'pending',
            ];

            // Handle photo upload
            if ($request->hasFile('tenant_photo')) {
                $photoPath = $request->file('tenant_photo')->store('maintenance_photos', 'public');
                $data['tenant_photo'] = $photoPath;
            }

            $maintenanceRequest = MaintenanceRequest::create($data);

            // Notify admin about new request
            $this->notifyAdminNewRequest($maintenanceRequest);

            return redirect()->route('tenant.maintenance.index')
                ->with('success', 'Maintenance request submitted successfully. Admin will assign it to staff.');
        }
        
        // Admin validation
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'room_id' => 'nullable|exists:rooms,room_id',
            'issue_type' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'request_date' => 'required|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $maintenanceRequest = MaintenanceRequest::create([
            'tenant_id' => $request->tenant_id,
            'room_id' => $request->room_id,
            'issue_type' => $request->issue_type,
            'description' => $request->description,
            'request_date' => $request->request_date,
            'priority' => $request->priority,
            'status' => 'pending',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($maintenance)
    {
        // Get the maintenance request ID from route parameter
        $requestId = $maintenance;
        
        // If it's already a model instance, get the ID
        if ($maintenance instanceof MaintenanceRequest) {
            $requestId = $maintenance->request_id;
            $maintenanceModel = $maintenance;
        } else {
            // Convert to integer if it's numeric
            $requestId = is_numeric($requestId) ? (int)$requestId : $requestId;
            
            // Find the maintenance request
            $maintenanceModel = MaintenanceRequest::where('request_id', $requestId)->first();
            if (!$maintenanceModel) {
                abort(404, 'Maintenance request not found.');
            }
        }
        
        // Get route name and path to determine context
        $route = request()->route();
        $routeName = $route ? $route->getName() : '';
        $path = request()->path();
        
        // Check if this is a tenant request
        $isTenantRoute = ($routeName && (strpos($routeName, 'tenant.maintenance') !== false || strpos($routeName, 'tenant.') === 0))
                        || strpos($path, 'tenant/maintenance') !== false
                        || strpos($path, 'tenant/maintenance-requests') !== false;
        
        if ($isTenantRoute) {
            // Additional safety check: verify user is logged in as tenant
            if (session('user_type') !== 'tenant') {
                abort(403, 'Unauthorized access to maintenance request.');
            }
            
            $maintenanceModel->loadMissing(['room', 'tasks', 'assignedStaff']);
            $maintenance = $maintenanceModel;
            return view('tenant.maintenance.show', compact('maintenance'));
        }
        
        // Admin view - ensure all relationships are loaded
        $maintenanceModel->loadMissing(['tenant', 'room', 'tasks', 'assignedStaff']);
        $maintenance = $maintenanceModel;
        
        return view('admin.maintenance.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($maintenance)
    {
        try {
            // Get the maintenance request ID from route parameter
            $requestId = $maintenance;
            
            // If it's already a model instance, use it directly
            if ($maintenance instanceof MaintenanceRequest) {
                $maintenanceModel = $maintenance;
            } else {
                // Convert to integer if it's numeric
                $requestId = is_numeric($requestId) ? (int)$requestId : $requestId;
                
                // Find the maintenance request
                $maintenanceModel = MaintenanceRequest::where('request_id', $requestId)->first();
                if (!$maintenanceModel) {
                    abort(404, 'Maintenance request not found.');
                }
            }
            
            // Get route name and path to determine context
            $route = request()->route();
            $routeName = $route ? $route->getName() : '';
            $path = request()->path();
            
            // Check if this is a tenant request
            $isTenantRoute = ($routeName && (strpos($routeName, 'tenant.maintenance') !== false || strpos($routeName, 'tenant.') === 0))
                            || strpos($path, 'tenant/maintenance') !== false
                            || strpos($path, 'tenant/maintenance-requests') !== false;
            
            if ($isTenantRoute) {
                // Additional safety check: verify user is logged in as tenant
                if (session('user_type') !== 'tenant') {
                    abort(403, 'Unauthorized access to maintenance request.');
                }
                
                $rooms = Room::all();
                return view('tenant.maintenance.edit', ['maintenance' => $maintenanceModel, 'rooms' => $rooms]);
            }
            
            // Admin view
            $tenants = Tenant::all();
            $rooms = Room::all();
            
            return view('admin.maintenance.edit', ['maintenance' => $maintenanceModel, 'tenants' => $tenants, 'rooms' => $rooms]);
        } catch (\Exception $e) {
            abort(500, 'Error loading maintenance request: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $maintenance)
    {
        // Handle route model binding - if it's not already a model, resolve it
        if (!$maintenance instanceof MaintenanceRequest) {
            $maintenance = MaintenanceRequest::where('request_id', $maintenance)->first();
            if (!$maintenance) {
                abort(404, 'Maintenance request not found.');
            }
        }
        
        // Get route name and path to determine context
        $route = request()->route();
        $routeName = $route ? $route->getName() : '';
        $path = request()->path();
        
        // Check if this is a tenant request
        $isTenantRoute = ($routeName && (strpos($routeName, 'tenant.maintenance') !== false || strpos($routeName, 'tenant.') === 0))
                        || strpos($path, 'tenant/maintenance') !== false
                        || strpos($path, 'tenant/maintenance-requests') !== false;
        
        if ($isTenantRoute) {
            // Route model binding already ensures tenant can only update their own requests
            // Additional safety check: verify user is logged in as tenant
            if (session('user_type') !== 'tenant') {
                abort(403, 'Unauthorized access to maintenance request.');
            }
            
            $request->validate([
                'room_id' => 'nullable|exists:rooms,room_id',
                'issue_type' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'request_date' => 'required|date',
                'priority' => 'required|in:low,medium,high,urgent',
            ]);

            $maintenance->update([
                'room_id' => $request->room_id,
                'issue_type' => $request->issue_type,
                'description' => $request->description,
                'request_date' => $request->request_date,
                'priority' => $request->priority,
            ]);

            return redirect()->route('tenant.maintenance.index')
                ->with('success', 'Maintenance request updated successfully.');
        }
        
        // Admin validation
        $request->validate([
            'tenant_id' => 'required|exists:tenants,tenant_id',
            'room_id' => 'nullable|exists:rooms,room_id',
            'issue_type' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'request_date' => 'required|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $maintenance->update($request->all());

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($maintenance)
    {
        // Handle route model binding - if it's not already a model, resolve it
        if (!$maintenance instanceof MaintenanceRequest) {
            $maintenance = MaintenanceRequest::where('request_id', $maintenance)->first();
            if (!$maintenance) {
                abort(404, 'Maintenance request not found.');
            }
        }
        
        // Get route name and path to determine context
        $route = request()->route();
        $routeName = $route ? $route->getName() : '';
        $path = request()->path();
        
        // Check if this is a tenant request
        $isTenantRoute = ($routeName && (strpos($routeName, 'tenant.maintenance') !== false || strpos($routeName, 'tenant.') === 0))
                        || strpos($path, 'tenant/maintenance') !== false
                        || strpos($path, 'tenant/maintenance-requests') !== false;
        
        if ($isTenantRoute) {
            // Ensure tenant can only delete their own requests
            $tenantId = session('user_id');
            $userType = session('user_type');
            
            if ($userType !== 'tenant' || !$tenantId || !$maintenance->tenant_id || (int)$maintenance->tenant_id !== (int)$tenantId) {
                abort(403, 'Unauthorized access to maintenance request.');
            }
            
            $maintenance->delete();

            return redirect()->route('tenant.maintenance.index')
                ->with('success', 'Maintenance request deleted successfully.');
        }
        
        // Admin view
        $maintenance->delete();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance request deleted successfully.');
    }

    /**
     * Assign maintenance request to staff (Admin action)
     */
    public function assignToStaff(Request $request, $maintenance)
    {
        // Handle route model binding - if it's not already a model, resolve it
        if (!$maintenance instanceof MaintenanceRequest) {
            $maintenance = MaintenanceRequest::where('request_id', $maintenance)->first();
            if (!$maintenance) {
                abort(404, 'Maintenance request not found.');
            }
        }
        
        $request->validate([
            'assigned_staff_id' => 'required|exists:staff,staff_id',
            'assignment_notes' => 'nullable|string|max:1000',
        ]);

        $maintenance->update([
            'assigned_staff_id' => $request->assigned_staff_id,
            'status' => 'assigned',
            'assigned_at' => now(),
            'assignment_notes' => $request->assignment_notes,
        ]);

        // Notify assigned staff
        $this->notifyStaffAssignment($maintenance);

        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance request assigned to staff successfully.');
    }

    /**
     * Staff marks request as in progress
     */
    public function markInProgress(MaintenanceRequest $maintenance)
    {
        if ($maintenance->assigned_staff_id != session('user_id')) {
            return redirect()->back()->with('error', 'Unauthorized access to maintenance request.');
        }

        $maintenance->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        // Notify tenant
        $this->notifyTenantStatusUpdate($maintenance, 'in_progress');

        return redirect()->back()->with('success', 'Maintenance request marked as in progress.');
    }

    /**
     * Staff completes request with proof
     */
    public function completeRequest(Request $request, MaintenanceRequest $maintenance)
    {
        if ($maintenance->assigned_staff_id != session('user_id')) {
            return redirect()->back()->with('error', 'Unauthorized access to maintenance request.');
        }

        $request->validate([
            'staff_report' => 'required|string|max:1000',
            'staff_proof_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'status' => 'completed',
            'completed_at' => now(),
            'staff_report' => $request->staff_report,
        ];

        // Handle proof photo upload
        if ($request->hasFile('staff_proof_photo')) {
            $photoPath = $request->file('staff_proof_photo')->store('maintenance_proof', 'public');
            $data['staff_proof_photo'] = $photoPath;
        }

        $maintenance->update($data);

        // Notify tenant for confirmation
        $this->notifyTenantForConfirmation($maintenance);

        return redirect()->back()->with('success', 'Maintenance request completed. Waiting for tenant confirmation.');
    }

    /**
     * Tenant confirms completion
     */
    public function confirmCompletion($id)
    {
        // Verify user is logged in as tenant
        if (session('user_type') !== 'tenant') {
            return redirect()->back()->with('error', 'Unauthorized access to maintenance request.');
        }
        
        $tenantId = session('user_id');
        if (!$tenantId) {
            abort(403, 'Unauthorized access.');
        }
        
        // Find the maintenance request and ensure it belongs to the current tenant
        $maintenance = MaintenanceRequest::where('request_id', $id)
            ->where('tenant_id', $tenantId)
            ->first();
            
        if (!$maintenance) {
            abort(404, 'Maintenance request not found or you do not have access to it.');
        }

        $maintenance->update([
            'status' => 'tenant_confirmed',
            'tenant_confirmed_at' => now(),
        ]);

        // Notify admin for review
        $this->notifyAdminForReview($maintenance);

        return redirect()->back()->with('success', 'Maintenance completion confirmed. Admin will review and close the request.');
    }

    /**
     * Admin closes the request
     */
    public function closeRequest($maintenance)
    {
        // Handle route model binding - if it's not already a model, resolve it
        if (!$maintenance instanceof MaintenanceRequest) {
            $maintenance = MaintenanceRequest::where('request_id', $maintenance)->first();
            if (!$maintenance) {
                abort(404, 'Maintenance request not found.');
            }
        }
        
        $maintenance->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Maintenance request closed successfully.');
    }

    /**
     * Notify admin about new request
     */
    private function notifyAdminNewRequest($maintenanceRequest)
    {
        \App\Models\Notification::create([
            'notifiable_type' => 'App\Models\Admin',
            'notifiable_id' => 1, // Assuming admin ID is 1
            'type' => 'maintenance_request',
            'title' => 'New Maintenance Request',
            'message' => "New maintenance request from {$maintenanceRequest->tenant->name}: {$maintenanceRequest->issue_type}",
            'data' => json_encode([
                'request_id' => $maintenanceRequest->request_id,
                'tenant_id' => $maintenanceRequest->tenant_id,
                'priority' => $maintenanceRequest->priority,
                'issue_type' => $maintenanceRequest->issue_type,
            ]),
        ]);
    }

    /**
     * Notify staff about assignment
     */
    private function notifyStaffAssignment($maintenanceRequest)
    {
        \App\Models\Notification::create([
            'notifiable_type' => 'App\Models\Staff',
            'notifiable_id' => $maintenanceRequest->assigned_staff_id,
            'type' => 'maintenance_assignment',
            'title' => 'Maintenance Request Assigned',
            'message' => "You have been assigned a maintenance request: {$maintenanceRequest->issue_type}",
            'data' => json_encode([
                'request_id' => $maintenanceRequest->request_id,
                'tenant_id' => $maintenanceRequest->tenant_id,
                'priority' => $maintenanceRequest->priority,
                'issue_type' => $maintenanceRequest->issue_type,
            ]),
        ]);
    }

    /**
     * Notify tenant about status update
     */
    private function notifyTenantStatusUpdate($maintenanceRequest, $status)
    {
        \App\Models\Notification::create([
            'notifiable_type' => 'App\Models\Tenant',
            'notifiable_id' => $maintenanceRequest->tenant_id,
            'type' => 'maintenance_status',
            'title' => 'Maintenance Status Update',
            'message' => "Your maintenance request status has been updated to: " . ucfirst(str_replace('_', ' ', $status)),
            'data' => json_encode([
                'request_id' => $maintenanceRequest->request_id,
                'status' => $status,
                'issue_type' => $maintenanceRequest->issue_type,
            ]),
        ]);
    }

    /**
     * Notify tenant for confirmation
     */
    private function notifyTenantForConfirmation($maintenanceRequest)
    {
        \App\Models\Notification::create([
            'notifiable_type' => 'App\Models\Tenant',
            'notifiable_id' => $maintenanceRequest->tenant_id,
            'type' => 'maintenance_completion',
            'title' => 'Maintenance Completed - Please Confirm',
            'message' => "Your maintenance request has been completed. Please confirm if the issue is resolved.",
            'data' => json_encode([
                'request_id' => $maintenanceRequest->request_id,
                'issue_type' => $maintenanceRequest->issue_type,
                'staff_report' => $maintenanceRequest->staff_report,
            ]),
        ]);
    }

    /**
     * Notify admin for review
     */
    private function notifyAdminForReview($maintenanceRequest)
    {
        \App\Models\Notification::create([
            'notifiable_type' => 'App\Models\Admin',
            'notifiable_id' => 1, // Assuming admin ID is 1
            'type' => 'maintenance_review',
            'title' => 'Maintenance Request Ready for Review',
            'message' => "Maintenance request #{$maintenanceRequest->request_id} has been confirmed by tenant and is ready for review.",
            'data' => json_encode([
                'request_id' => $maintenanceRequest->request_id,
                'tenant_id' => $maintenanceRequest->tenant_id,
                'issue_type' => $maintenanceRequest->issue_type,
            ]),
        ]);
    }
}
