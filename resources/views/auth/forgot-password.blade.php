@extends('layouts.app')

@section('title', 'Forgot Password - Boarding House Management System')

@section('content')
<!-- Forgot Password Page: Full-height centered layout with gradient background -->
<div class="min-vh-100 d-flex align-items-center justify-content-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #c7d2fe 100%);">
    
    <!-- Background Decorative Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0;">
        <!-- Large floating circles for visual effect -->
        <div class="position-absolute rounded-circle opacity-25" 
             style="width: 400px; height: 400px; background: linear-gradient(135deg, #60a5fa, #3b82f6); top: -200px; right: -200px; filter: blur(60px);"></div>
        <div class="position-absolute rounded-circle opacity-25" 
             style="width: 350px; height: 350px; background: linear-gradient(135deg, #22d3ee, #06b6d4); bottom: -175px; left: -175px; filter: blur(60px);"></div>
    </div>
    
    <!-- Forgot Password Card Container: Responsive width with padding -->
    <div class="position-relative z-1 w-100" style="max-width: 500px;">
        <div class="container px-3 px-md-4">
            
            <!-- Forgot Password Card: Glass morphism effect with Bootstrap card -->
            <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 1.5rem !important;">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Logo and Title Section -->
                    <div class="text-center mb-4 mb-md-5">
                        <div class="d-flex align-items-center justify-content-center mb-4">
                            <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center shadow" 
                                 style="width: 56px; height: 56px;">
                                <i class="fas fa-key text-white fs-5"></i>
                            </div>
                            <div class="text-start ms-3">
                                <h1 class="h5 fw-bold text-primary mb-0">Reset your password</h1>
                                <p class="small text-muted mb-0" id="subtitle-text">Find your account</p>
                            </div>
                        </div>
                    </div>
                    
                    @if(!session('user_found'))
                    <!-- Step 1: Find Account Form -->
                    <form method="POST" action="{{ route('password.find') }}" id="findAccountForm">
                        @csrf

                        <!-- Email/Phone Input Field -->
                        <div class="mb-3">
                            <label for="identifier" class="form-label fw-semibold text-primary">Email Address or Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input id="identifier" 
                                       name="identifier" 
                                       type="text" 
                                       required 
                                       class="form-control border-start-0 @error('identifier') is-invalid @enderror" 
                                       placeholder="Enter your email or phone number" 
                                       value="{{ old('identifier') }}">
                                @error('identifier')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Error Messages Display -->
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <!-- Search Account Button -->
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </form>
                    @else
                    <!-- Step 2: Select Reset Method -->
                    <div id="resetMethodSection">
                        <p class="mb-4 text-primary fw-semibold">How do you want to get the code to reset your password?</p>
                        
                        <!-- User Info Display -->
                        @if(session('user_found'))
                            <div class="d-flex align-items-center mb-4 p-3 rounded" style="background: rgba(0, 102, 255, 0.05);">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(0, 102, 255, 0.15), rgba(0, 102, 255, 0.08)); border: 2px solid rgba(0, 102, 255, 0.3);">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-primary">{{ session('user_name') }}</div>
                                    <div class="small text-muted">Account user</div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" id="resetMethodForm">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('user_email') ?? old('email') }}">
                            <input type="hidden" name="reset_method" id="resetMethod" value="email">

                            <!-- Reset Method Options -->
                            <div class="mb-4">
                                <!-- Email Option -->
                                <div class="form-check mb-3 p-3 rounded border" style="border-color: rgba(0, 102, 255, 0.2) !important; cursor: pointer;" onclick="selectMethod('email')">
                                    <input class="form-check-input" type="radio" name="method" id="method_email" value="email" checked>
                                    <label class="form-check-label w-100" for="method_email" style="cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-envelope text-primary me-3 fs-5"></i>
                                            <div>
                                                <div class="fw-semibold text-primary">Send code via email</div>
                                                <div class="small text-muted">
                                                    @if(session('user_email'))
                                                        @php
                                                            $email = session('user_email');
                                                            $parts = explode('@', $email);
                                                            $local = $parts[0];
                                                            $domain = $parts[1] ?? '';
                                                            $maskedLocal = strlen($local) > 2 ? substr($local, 0, 1) . str_repeat('*', strlen($local) - 2) . substr($local, -1) : $local;
                                                            $domainParts = explode('.', $domain);
                                                            $maskedDomain = !empty($domainParts[0]) ? substr($domainParts[0], 0, 1) . '***' . (count($domainParts) > 1 ? '.' . end($domainParts) : '') : $domain;
                                                        @endphp
                                                        {{ $maskedLocal }}@{{ $maskedDomain }}
                                                    @else
                                                        Email address
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <!-- SMS Option -->
                                @if(session('user_contact'))
                                <div class="form-check mb-3 p-3 rounded border" style="border-color: rgba(0, 102, 255, 0.2) !important; cursor: pointer;" onclick="selectMethod('sms')">
                                    <input class="form-check-input" type="radio" name="method" id="method_sms" value="sms">
                                    <label class="form-check-label w-100" for="method_sms" style="cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-sms text-primary me-3 fs-5"></i>
                                            <div>
                                                <div class="fw-semibold text-primary">Send code via SMS</div>
                                                <div class="small text-muted">
                                                    @php
                                                        $phone = session('user_contact');
                                                        $masked = strlen($phone) > 4 ? substr($phone, 0, 2) . str_repeat('*', strlen($phone) - 4) . substr($phone, -2) : $phone;
                                                    @endphp
                                                    {{ $masked }}
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endif

                                <!-- WhatsApp Option -->
                                @if(session('user_contact'))
                                <div class="form-check mb-3 p-3 rounded border" style="border-color: rgba(0, 102, 255, 0.2) !important; cursor: pointer;" onclick="selectMethod('whatsapp')">
                                    <input class="form-check-input" type="radio" name="method" id="method_whatsapp" value="whatsapp">
                                    <label class="form-check-label w-100" for="method_whatsapp" style="cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-whatsapp text-success me-3 fs-5"></i>
                                            <div>
                                                <div class="fw-semibold text-primary">Send code via WhatsApp</div>
                                                <div class="small text-muted">{{ session('user_contact') }}</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endif
                            </div>

                            <!-- Continue Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow mb-3">
                                <i class="fas fa-paper-plane me-2"></i>Continue
                            </button>
                        </form>

                        <!-- Back Button -->
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-primary fw-semibold">
                                <i class="fas fa-arrow-left me-2"></i>Not you?
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Back to Login Link Section -->
                    <div class="mt-4 text-center">
                        <p class="text-muted mb-0">
                            Remember your password? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">
                                Back to Login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectMethod(method) {
    document.getElementById('resetMethod').value = method;
    document.getElementById('method_' + method).checked = true;
}

// Helper functions for masking (if needed in frontend)
function maskEmail(email) {
    if (!email) return '';
    const [local, domain] = email.split('@');
    if (local.length <= 2) return email;
    const masked = local[0] + '*'.repeat(local.length - 2) + local[local.length - 1];
    return masked + '@' + domain.replace(/(.{1})(.*)(.{1})/, '$1***$3');
}

function maskPhone(phone) {
    if (!phone) return '';
    if (phone.length <= 4) return phone;
    return phone.slice(0, 2) + '*'.repeat(phone.length - 4) + phone.slice(-2);
}
</script>
@endsection
