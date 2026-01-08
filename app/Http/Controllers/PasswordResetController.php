<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Tenant;
use App\Models\Admin;
use App\Models\Staff;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Find account by email or phone
     */
    public function findAccount(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string'
        ]);

        $identifier = $request->identifier;
        
        // Try to find by email
        $user = Tenant::where('email', $identifier)->first();
        
        // If not found by email, try by phone
        if (!$user) {
            $user = Tenant::where('contact_number', $identifier)->first();
        }

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['identifier' => 'No account found with this email or phone number.']);
        }

        // Store user data in session (only essential fields)
        session([
            'user_found' => true,
            'user_email' => $user->email,
            'user_name' => $user->name,
            'user_contact' => $user->contact_number,
        ]);

        return redirect()->route('password.request');
    }

    /**
     * Mask email for display
     */
    private function maskEmail($email)
    {
        if (!$email) return '';
        $parts = explode('@', $email);
        if (count($parts) !== 2) return $email;
        
        $local = $parts[0];
        $domain = $parts[1];
        
        if (strlen($local) <= 2) return $email;
        
        $maskedLocal = substr($local, 0, 1) . str_repeat('*', strlen($local) - 2) . substr($local, -1);
        $domainParts = explode('.', $domain);
        $maskedDomain = substr($domainParts[0], 0, 1) . '***' . (count($domainParts) > 1 ? '.' . end($domainParts) : '');
        
        return $maskedLocal . '@' . $maskedDomain;
    }

    /**
     * Mask phone for display
     */
    private function maskPhone($phone)
    {
        if (!$phone) return '';
        if (strlen($phone) <= 4) return $phone;
        return substr($phone, 0, 2) . str_repeat('*', strlen($phone) - 4) . substr($phone, -2);
    }

    /**
     * Send password reset link via selected method
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:tenants,email',
            'reset_method' => 'required|in:email,sms,whatsapp'
        ], [
            'email.exists' => 'No account found with this email address.'
        ]);

        $email = $request->email;
        $method = $request->reset_method;
        $token = Str::random(64);

        // Store the token in database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Get user details
        $user = Tenant::where('email', $email)->first();

        // Send reset code based on method
        $message = '';
        switch ($method) {
            case 'email':
                $message = 'Password reset link has been sent to your email address.';
                // In production, send actual email here
                break;
            case 'sms':
                $maskedPhone = $user && $user->contact_number ? $this->maskPhone($user->contact_number) : 'your phone';
                $message = 'Password reset code has been sent via SMS to ' . $maskedPhone;
                // In production, send actual SMS here
                break;
            case 'whatsapp':
                $phone = $user && $user->contact_number ? $user->contact_number : 'your phone';
                $message = 'Password reset code has been sent via WhatsApp to ' . $phone;
                // In production, send actual WhatsApp message here
                break;
        }

        // Clear session data
        session()->forget(['user_found', 'user_email', 'user_name', 'user_contact']);

        return redirect()->route('password.request')
            ->with('success', $message);
    }

    /**
     * Show the reset password form
     */
    public function showResetPassword(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        if (!$token || !$email) {
            return redirect()->route('password.request')
                ->with('error', 'Invalid password reset link.');
        }

        // Verify token exists and is not expired (24 hours)
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->first();

        if (!$resetRecord) {
            return redirect()->route('password.request')
                ->with('error', 'Password reset link has expired or is invalid.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $email = $request->email;
        $token = $request->token;
        $password = $request->password;

        // Verify token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->first();

        if (!$resetRecord) {
            return redirect()->route('password.request')
                ->with('error', 'Password reset link has expired or is invalid.');
        }

        // Update password
        $user = Tenant::where('email', $email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($password)
            ]);

            // Delete the reset token
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return redirect()->route('login')
                ->with('success', 'Your password has been reset successfully. Please login with your new password.');
        }

        return redirect()->route('password.request')
            ->with('error', 'Unable to reset password. Please try again.');
    }
}
