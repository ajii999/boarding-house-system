@extends('layouts.app')

@section('title', 'Sign in - Boarding House Management System')

@section('content')
<!-- Login Page: Full-height centered layout with gradient background -->
<div class="min-vh-100 d-flex align-items-center justify-content-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #c7d2fe 100%);">
    
    <!-- Background Decorative Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0;">
        <!-- Large floating circles for visual effect -->
        <div class="position-absolute rounded-circle opacity-25" 
             style="width: 400px; height: 400px; background: linear-gradient(135deg, #60a5fa, #3b82f6); top: -200px; right: -200px; filter: blur(60px);"></div>
        <div class="position-absolute rounded-circle opacity-25" 
             style="width: 350px; height: 350px; background: linear-gradient(135deg, #22d3ee, #06b6d4); bottom: -175px; left: -175px; filter: blur(60px);"></div>
    </div>
    
    <!-- Login Card Container: Responsive width with padding -->
    <div class="position-relative z-1 w-100" style="max-width: 450px;">
        <div class="container px-3 px-md-4">
            
            <!-- Login Card: Glass morphism effect with Bootstrap card -->
            <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 1.5rem !important;">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Logo and Title Section -->
                    <div class="text-center mb-4 mb-md-5">
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center shadow" 
                                 style="width: 56px; height: 56px;">
                                <i class="fas fa-home text-white fs-5"></i>
                            </div>
                            <div class="text-start ms-3">
                                <h1 class="h5 fw-bold text-primary mb-0">Boarding House</h1>
                                <h1 class="h5 fw-bold text-primary mb-0">Management System</h1>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Input Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-primary">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       autocomplete="email" 
                                       required 
                                       class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       placeholder="Enter your email" 
                                       value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Input Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-primary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input id="password" 
                                       name="password" 
                                       type="password" 
                                       autocomplete="current-password" 
                                       required 
                                       class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                       placeholder="Enter your password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password Row -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label text-primary" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">
                                    Forgot Password?
                                </a>
                            </div>
                        </div>

                        <!-- Error Messages Display -->
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <!-- Login Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </form>

                    <!-- Register Link Section -->
                    <div class="mt-4 text-center">
                        <p class="text-muted mb-0">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">
                                Register
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
