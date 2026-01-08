@extends('layouts.app')

@section('title', 'Register - Boarding House Management System')

@section('content')
<!-- Register Page: Full-height centered layout with gradient background -->
<div class="min-vh-100 d-flex align-items-center justify-content-center py-4 py-md-5" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 50%, #a5b4fc 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                
                <!-- Register Card: Bootstrap card with glass morphism effect -->
                <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 1.5rem !important;">
                    <div class="card-body p-4 p-md-5">
                        
                        <!-- Logo and Title Section -->
                        <div class="text-center mb-4 mb-md-5">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-user-plus text-white"></i>
                            </div>
                            <h2 class="h3 fw-bold text-dark mb-2">Create Tenant Account</h2>
                            <p class="text-muted mb-0">Register as a new tenant</p>
                        </div>
                        
                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <!-- Form Fields: Responsive grid layout -->
                            <div class="row g-3 mb-3">
                                
                                <!-- Full Name Field -->
                                <div class="col-12">
                                    <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input id="name" 
                                           name="name" 
                                           type="text" 
                                           required 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Enter your full name" 
                                           value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="col-12">
                                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input id="email" 
                                           name="email" 
                                           type="email" 
                                           required 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="Enter your email" 
                                           value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Contact Number Field -->
                                <div class="col-12 col-md-6">
                                    <label for="contact_number" class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                                    <input id="contact_number" 
                                           name="contact_number" 
                                           type="tel" 
                                           required 
                                           class="form-control @error('contact_number') is-invalid @enderror" 
                                           placeholder="Enter contact number" 
                                           value="{{ old('contact_number') }}">
                                    @error('contact_number')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Emergency Contact Field (Optional) -->
                                <div class="col-12 col-md-6">
                                    <label for="emergency_contact" class="form-label fw-semibold">Emergency Contact <small class="text-muted">(Optional)</small></label>
                                    <input id="emergency_contact" 
                                           name="emergency_contact" 
                                           type="tel" 
                                           class="form-control" 
                                           placeholder="Emergency contact number" 
                                           value="{{ old('emergency_contact') }}">
                                </div>

                                <!-- Password Field -->
                                <div class="col-12 col-md-6">
                                    <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                    <input id="password" 
                                           name="password" 
                                           type="password" 
                                           required 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Enter password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="col-12 col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                    <input id="password_confirmation" 
                                           name="password_confirmation" 
                                           type="password" 
                                           required 
                                           class="form-control" 
                                           placeholder="Confirm password">
                                </div>

                                <!-- Address Field (Optional) -->
                                <div class="col-12">
                                    <label for="address" class="form-label fw-semibold">Address <small class="text-muted">(Optional)</small></label>
                                    <textarea id="address" 
                                              name="address" 
                                              rows="3" 
                                              class="form-control" 
                                              placeholder="Enter your address">{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <!-- Error Messages Display -->
                            @if ($errors->any())
                                <div class="alert alert-danger mb-3" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow mb-3">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </form>

                        <!-- Login Link Section -->
                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">
                                    Sign in
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
