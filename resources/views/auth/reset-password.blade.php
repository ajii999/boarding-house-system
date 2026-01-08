@extends('layouts.app')

@section('title', 'Reset Password - Boarding House Management System')

@section('content')
<div class="min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Blue Color Scheme Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-sky-200 to-indigo-300">
        <!-- Secondary gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-tr from-cyan-200/40 via-transparent to-blue-300/40"></div>
        
        <!-- Animated geometric shapes -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Large floating circles -->
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-blue-400/30 to-indigo-500/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-cyan-400/30 to-blue-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-br from-sky-400/30 to-blue-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
            
            <!-- Medium floating shapes -->
            <div class="absolute top-20 right-20 w-32 h-32 bg-gradient-to-br from-blue-400/40 to-cyan-500/40 rounded-full blur-2xl animate-bounce" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 right-1/3 w-24 h-24 bg-gradient-to-br from-indigo-400/40 to-blue-500/40 rounded-full blur-2xl animate-bounce" style="animation-delay: 3s;"></div>
            <div class="absolute top-1/3 left-20 w-28 h-28 bg-gradient-to-br from-sky-400/40 to-cyan-500/40 rounded-full blur-2xl animate-bounce" style="animation-delay: 5s;"></div>
            
            <!-- Small floating particles -->
            <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-white/60 rounded-full animate-ping"></div>
            <div class="absolute top-1/3 right-1/3 w-3 h-3 bg-blue-300/70 rounded-full animate-ping" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-1/3 left-1/3 w-2 h-2 bg-cyan-300/80 rounded-full animate-ping" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-1/4 right-1/4 w-3 h-3 bg-sky-300/70 rounded-full animate-ping" style="animation-delay: 3s;"></div>
            <div class="absolute top-1/2 left-1/2 w-2 h-2 bg-indigo-300/80 rounded-full animate-ping" style="animation-delay: 4s;"></div>
        </div>
        
        <!-- Light rays effect -->
        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/10 to-transparent animate-pulse"></div>
    </div>

    <div class="relative z-10 w-full max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Blue Glass Morphism Card -->
        <div class="bg-white/20 backdrop-blur-lg rounded-3xl shadow-2xl border border-blue-200/30 p-8">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-lock text-white text-xl"></i>
                    </div>
                    <div class="text-left">
                        <h1 class="text-lg sm:text-xl font-bold text-blue-800 leading-tight">Reset Password</h1>
                        <p class="text-sm text-blue-600">Enter your new password</p>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-blue-700">New Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" autocomplete="new-password" required 
                               class="w-full px-4 py-3 bg-white/80 backdrop-blur-sm border border-blue-200 rounded-2xl text-blue-900 placeholder-blue-500/70 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200 @error('password') border-red-300 @enderror" 
                               placeholder="Enter your new password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-blue-500"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-blue-700">Confirm New Password</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                               class="w-full px-4 py-3 bg-white/80 backdrop-blur-sm border border-blue-200 rounded-2xl text-blue-900 placeholder-blue-500/70 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-200 @error('password_confirmation') border-red-300 @enderror" 
                               placeholder="Confirm your new password">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-blue-500"></i>
                        </div>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="bg-green-50/80 backdrop-blur-sm border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50/80 backdrop-blur-sm border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Reset Password Button -->
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-2xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>
                    Reset Password
                </button>
            </form>

            <!-- Back to Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-blue-700">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500 transition-colors duration-200">
                        Back to Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.backdrop-blur-lg {
    backdrop-filter: blur(16px);
}

.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}

/* Ensure logo and text look good at small sizes */
@media (max-width: 640px) {
    .text-lg {
        font-size: 1rem;
    }
    
    .text-xl {
        font-size: 1.125rem;
    }
    
    .text-2xl {
        font-size: 1.5rem;
    }
    
    .text-3xl {
        font-size: 1.875rem;
    }
}
</style>
@endsection
