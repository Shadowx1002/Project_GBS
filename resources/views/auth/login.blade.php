@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-secondary-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center" data-aos="fade-up">
            <div class="mx-auto h-16 w-16 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
            <p class="mt-2 text-sm text-gray-600">
                Sign in to your GelBlaster Pro account
            </p>
        </div>

        <!-- Login Form -->
        <div class="card p-8 shadow-xl" data-aos="fade-up" data-aos-delay="200">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="form-label">Email Address</label>
                    <div class="relative">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               autocomplete="email" 
                               required 
                               class="form-input pl-12 @error('email') border-red-500 @enderror" 
                               placeholder="Enter your email"
                               value="{{ old('email') }}">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                    </div>
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="form-label">Password</label>
                    <div class="relative">
                        <input id="password" 
                               name="password" 
                               type="password" 
                               autocomplete="current-password" 
                               required 
                               class="form-input pl-12 pr-12 @error('password') border-red-500 @enderror" 
                               placeholder="Enter your password">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <button type="button" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password')">
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="password-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" 
                               name="remember" 
                               type="checkbox" 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-primary-600 hover:text-primary-700 transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full btn-primary flex justify-center items-center relative overflow-hidden group">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign In
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-700 to-primary-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-700 transition-colors">
                            Sign up here
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="text-center space-y-4" data-aos="fade-up" data-aos-delay="400">

            <!-- Security Notice -->
            <div class="inline-flex items-center space-x-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span>Your data is secure and protected</span>
            </div>
        </div>

        <!-- Demo Credentials (Remove in production) -->
        @if(app()->environment('local'))
            <div class="card p-4 bg-blue-50 border border-blue-200" data-aos="fade-up" data-aos-delay="600">
                <h4 class="text-sm font-medium text-blue-900 mb-2">Demo Credentials</h4>
                <div class="text-xs text-blue-800 space-y-1">
                    <p><strong>Admin:</strong> admin@gelblaster.com / password</p>
                    <p><strong>User:</strong> user@gelblaster.com / password</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Background Animation -->
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-secondary-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-400"></div>
    <div class="absolute top-40 left-1/2 transform -translate-x-1/2 w-80 h-80 bg-accent-200 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-600"></div>
</div>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById('password-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
        `;
    } else {
        field.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
    }
}

// Auto-focus email field
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('email').focus();
});

// Form validation enhancement
document.querySelector('form').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!email || !password) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        return;
    }
    
    // Show loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    submitButton.disabled = true;
    submitButton.innerHTML = `
        <div class="spinner mr-2"></div>
        Signing In...
    `;
    
    // Reset button if form doesn't submit (for client-side validation errors)
    setTimeout(() => {
        if (submitButton.disabled) {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    }, 5000);
});

// Remember me enhancement
const rememberCheckbox = document.getElementById('remember_me');
const emailInput = document.getElementById('email');

// Load remembered email
const rememberedEmail = localStorage.getItem('remembered_email');
if (rememberedEmail) {
    emailInput.value = rememberedEmail;
    rememberCheckbox.checked = true;
}

// Save/clear remembered email
document.querySelector('form').addEventListener('submit', function() {
    if (rememberCheckbox.checked) {
        localStorage.setItem('remembered_email', emailInput.value);
    } else {
        localStorage.removeItem('remembered_email');
    }
});

// Clear remembered email when unchecking
rememberCheckbox.addEventListener('change', function() {
    if (!this.checked) {
        localStorage.removeItem('remembered_email');
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Alt + L to focus email
    if (e.altKey && e.key === 'l') {
        e.preventDefault();
        document.getElementById('email').focus();
    }
    
    // Alt + P to focus password
    if (e.altKey && e.key === 'p') {
        e.preventDefault();
        document.getElementById('password').focus();
    }
});

// Input enhancement - remove error styling on input
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('input', function() {
        this.classList.remove('border-red-500');
        const errorElement = this.parentElement.parentElement.querySelector('.form-error');
        if (errorElement) {
            errorElement.style.opacity = '0';
            setTimeout(() => {
                if (errorElement.style.opacity === '0') {
                    errorElement.remove();
                }
            }, 300);
        }
    });
});

// Caps lock detection
document.getElementById('password').addEventListener('keypress', function(e) {
    const capsLockOn = e.getModifierState && e.getModifierState('CapsLock');
    const warning = document.getElementById('caps-warning');
    
    if (capsLockOn) {
        if (!warning) {
            const capsWarning = document.createElement('p');
            capsWarning.id = 'caps-warning';
            capsWarning.className = 'text-xs text-orange-600 mt-1';
            capsWarning.innerHTML = '⚠️ Caps Lock is on';
            this.parentElement.parentElement.appendChild(capsWarning);
        }
    } else {
        if (warning) {
            warning.remove();
        }
    }
});
</script>
@endpush
@endsection