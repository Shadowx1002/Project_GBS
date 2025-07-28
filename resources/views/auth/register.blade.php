@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-secondary-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center" data-aos="fade-up">
            <div class="mx-auto h-12 w-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Create your account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Join the GelBlaster Pro community
            </p>
        </div>

        <!-- Registration Form -->
        <div class="card p-8" data-aos="fade-up" data-aos-delay="200">
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" 
                           name="name" 
                           type="text" 
                           autocomplete="name" 
                           required 
                           class="form-input @error('name') border-red-500 @enderror" 
                           placeholder="Enter your full name"
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           autocomplete="email" 
                           required 
                           class="form-input @error('email') border-red-500 @enderror" 
                           placeholder="Enter your email"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="form-label">Phone Number</label>
                    <input id="phone" 
                           name="phone" 
                           type="tel" 
                           autocomplete="tel" 
                           required 
                           class="form-input @error('phone') border-red-500 @enderror" 
                           placeholder="Enter your phone number"
                           value="{{ old('phone') }}">
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input id="date_of_birth" 
                           name="date_of_birth" 
                           type="date" 
                           required 
                           class="form-input @error('date_of_birth') border-red-500 @enderror"
                           value="{{ old('date_of_birth') }}">
                    <p class="mt-1 text-xs text-gray-500">You must be 18 or older to register</p>
                    @error('date_of_birth')
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
                               autocomplete="new-password" 
                               required 
                               class="form-input @error('password') border-red-500 @enderror pr-10" 
                               placeholder="Create a password">
                        <button type="button" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password')">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="relative">
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               autocomplete="new-password" 
                               required 
                               class="form-input @error('password_confirmation') border-red-500 @enderror pr-10" 
                               placeholder="Confirm your password">
                        <button type="button" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password_confirmation')">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" 
                               name="terms" 
                               type="checkbox" 
                               required
                               class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded @error('terms') border-red-500 @enderror">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            I agree to the 
                            <a href="#" class="text-primary-600 hover:text-primary-700 underline">Terms and Conditions</a>
                            and 
                            <a href="#" class="text-primary-600 hover:text-primary-700 underline">Privacy Policy</a>
                        </label>
                        @error('terms')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Age Verification Notice -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.729-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Age Verification Required</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>After registration, you'll need to verify your age by uploading a government-issued ID to purchase gel blasters. This is required by law.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full btn-primary flex justify-center items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Create Account
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-700 transition-colors">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Security Notice -->
        <div class="text-center" data-aos="fade-up" data-aos-delay="400">
            <div class="inline-flex items-center space-x-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>Your information is secure and protected</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);
}

// Real-time age validation
document.getElementById('date_of_birth').addEventListener('change', function() {
    const dob = new Date(this.value);
    const today = new Date();
    const age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    
    const errorElement = this.parentElement.querySelector('.form-error');
    const existingAgeError = this.parentElement.querySelector('.age-error');
    
    if (existingAgeError) {
        existingAgeError.remove();
    }
    
    if (age < 18) {
        const ageError = document.createElement('p');
        ageError.className = 'form-error age-error';
        ageError.textContent = 'You must be at least 18 years old to register.';
        this.parentElement.appendChild(ageError);
        this.classList.add('border-red-500');
    } else {
        this.classList.remove('border-red-500');
    }
});

// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    let strength = 0;
    
    // Length check
    if (password.length >= 8) strength++;
    // Uppercase check
    if (/[A-Z]/.test(password)) strength++;
    // Lowercase check
    if (/[a-z]/.test(password)) strength++;
    // Number check
    if (/[0-9]/.test(password)) strength++;
    // Special character check
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    // Remove existing strength indicator
    const existingIndicator = this.parentElement.parentElement.querySelector('.strength-indicator');
    if (existingIndicator) {
        existingIndicator.remove();
    }
    
    if (password.length > 0) {
        const indicator = document.createElement('div');
        indicator.className = 'strength-indicator mt-2';
        
        let strengthText = '';
        let strengthColor = '';
        
        switch (strength) {
            case 0-1:
                strengthText = 'Very Weak';
                strengthColor = 'bg-red-500';
                break;
            case 2:
                strengthText = 'Weak';
                strengthColor = 'bg-orange-500';
                break;
            case 3:
                strengthText = 'Fair';
                strengthColor = 'bg-yellow-500';
                break;
            case 4:
                strengthText = 'Good';
                strengthColor = 'bg-blue-500';
                break;
            case 5:
                strengthText = 'Strong';
                strengthColor = 'bg-green-500';
                break;
        }
        
        indicator.innerHTML = `
            <div class="flex items-center space-x-2">
                <div class="flex-1 bg-gray-200 rounded-full h-2">
                    <div class="${strengthColor} h-2 rounded-full transition-all duration-300" style="width: ${(strength / 5) * 100}%"></div>
                </div>
                <span class="text-xs text-gray-600">${strengthText}</span>
            </div>
        `;
        
        this.parentElement.parentElement.appendChild(indicator);
    }
});

// Real-time password confirmation validation
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmation = this.value;
    
    const existingError = this.parentElement.parentElement.querySelector('.confirmation-error');
    if (existingError) {
        existingError.remove();
    }
    
    if (confirmation.length > 0 && password !== confirmation) {
        const error = document.createElement('p');
        error.className = 'form-error confirmation-error';
        error.textContent = 'Passwords do not match.';
        this.parentElement.parentElement.appendChild(error);
        this.classList.add('border-red-500');
    } else {
        this.classList.remove('border-red-500');
    }
});
</script>
@endpush
@endsection