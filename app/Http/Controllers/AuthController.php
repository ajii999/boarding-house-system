<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Tenant;
use App\Models\Staff;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $email = $credentials['email'];

        // Try to find user in each model
        $user = null;
        $role = null;

        // Check Admin first
        $admin = Admin::where('email', $email)->first();
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            $user = $admin;
            $role = 'admin';
        }

        // Check Tenant if not found in Admin
        if (!$user) {
            $tenant = Tenant::where('email', $email)->first();
            if ($tenant && Hash::check($credentials['password'], $tenant->password)) {
                $user = $tenant;
                $role = 'tenant';
            }
        }

        // Check Staff if not found in Admin or Tenant
        if (!$user) {
            $staff = Staff::where('email', $email)->first();
            if ($staff && Hash::check($credentials['password'], $staff->password)) {
                $user = $staff;
                $role = 'staff';
            }
        }

        if ($user && $role) {
            // Store user info in session
            session([
                'user_id' => $user->getKey(),
                'user_type' => $role,
                'user_name' => $user->name ?? $user->first_name . ' ' . $user->last_name,
                'user_email' => $user->email,
            ]);

            return redirect()->route($role . '.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tenants,email,tenant_id',
            'password' => 'required|string|min:8|confirmed',
            'contact_number' => 'required|string|max:20',
        ]);

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
        ]);

        // Create profile
        $tenant->profile()->create([
            'address' => $request->address ?? '',
            'emergency_contact' => $request->emergency_contact ?? '',
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}
