@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <!-- Progress Bar -->
        <div class="mb-8" data-aos="fade-up">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-medium">
                            ✓
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Cart</span>
                    </div>
                    <div class="w-16 h-0.5 bg-primary-500"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-primary-500 text-white rounded-full flex items-center justify-center text-sm font-medium">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-primary-600">Checkout</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-medium">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Complete</span>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @csrf
            
            <!-- Left Column - Shipping & Payment -->
            <div class="space-y-6">
                <!-- Shipping Information -->
                <div class="card p-6" data-aos="fade-right">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Shipping Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="shipping_first_name" class="form-label">First Name</label>
                            <input type="text" 
                                   name="shipping_first_name" 
                                   id="shipping_first_name"
                                   class="form-input @error('shipping_first_name') border-red-500 @enderror"
                                   value="{{ old('shipping_first_name', explode(' ', $user->name)[0] ?? '') }}"
                                   required>
                            @error('shipping_first_name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="shipping_last_name" class="form-label">Last Name</label>
                            <input type="text" 
                                   name="shipping_last_name" 
                                   id="shipping_last_name"
                                   class="form-input @error('shipping_last_name') border-red-500 @enderror"
                                   value="{{ old('shipping_last_name', explode(' ', $user->name)[1] ?? '') }}"
                                   required>
                            @error('shipping_last_name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="shipping_email" class="form-label">Email Address</label>
                            <input type="email" 
                                   name="shipping_email" 
                                   id="shipping_email"
                                   class="form-input @error('shipping_email') border-red-500 @enderror"
                                   value="{{ old('shipping_email', $user->email) }}"
                                   required>
                            @error('shipping_email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="shipping_phone" class="form-label">Phone Number</label>
                            <input type="tel" 
                                   name="shipping_phone" 
                                   id="shipping_phone"
                                   class="form-input @error('shipping_phone') border-red-500 @enderror"
                                   value="{{ old('shipping_phone', $user->phone) }}">
                            @error('shipping_phone')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="shipping_address_line_1" class="form-label">Address Line 1</label>
                        <input type="text" 
                               name="shipping_address_line_1" 
                               id="shipping_address_line_1"
                               class="form-input @error('shipping_address_line_1') border-red-500 @enderror"
                               value="{{ old('shipping_address_line_1', $user->address_line_1) }}"
                               placeholder="Street address, P.O. box, company name"
                               required>
                        @error('shipping_address_line_1')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mt-4">
                        <label for="shipping_address_line_2" class="form-label">Address Line 2 (Optional)</label>
                        <input type="text" 
                               name="shipping_address_line_2" 
                               id="shipping_address_line_2"
                               class="form-input @error('shipping_address_line_2') border-red-500 @enderror"
                               value="{{ old('shipping_address_line_2', $user->address_line_2) }}"
                               placeholder="Apartment, suite, unit, building">
                        @error('shipping_address_line_2')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label for="shipping_city" class="form-label">City</label>
                            <input type="text" 
                                   name="shipping_city" 
                                   id="shipping_city"
                                   class="form-input @error('shipping_city') border-red-500 @enderror"
                                   value="{{ old('shipping_city', $user->city) }}"
                                   required>
                            @error('shipping_city')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="shipping_state" class="form-label">State / Province</label>
                            <input type="text" 
                                   name="shipping_state" 
                                   id="shipping_state"
                                   class="form-input @error('shipping_state') border-red-500 @enderror"
                                   value="{{ old('shipping_state', $user->state) }}"
                                   required>
                            @error('shipping_state')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="shipping_postal_code" class="form-label">ZIP / Postal Code</label>
                            <input type="text" 
                                   name="shipping_postal_code" 
                                   id="shipping_postal_code"
                                   class="form-input @error('shipping_postal_code') border-red-500 @enderror"
                                   value="{{ old('shipping_postal_code', $user->postal_code) }}"
                                   required>
                            @error('shipping_postal_code')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="shipping_country" class="form-label">Country</label>
                        <select name="shipping_country" 
                                id="shipping_country"
                                class="form-input @error('shipping_country') border-red-500 @enderror"
                                required>
                            <option value="">Select Country</option>
                            <option value="US" {{ old('shipping_country', $user->country) === 'US' ? 'selected' : '' }}>United States</option>
                            <option value="CA" {{ old('shipping_country', $user->country) === 'CA' ? 'selected' : '' }}>Canada</option>
                            <option value="AU" {{ old('shipping_country', $user->country) === 'AU' ? 'selected' : '' }}>Australia</option>
                            <option value="UK" {{ old('shipping_country', $user->country) === 'UK' ? 'selected' : '' }}>United Kingdom</option>
                        </select>
                        @error('shipping_country')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="card p-6" data-aos="fade-right" data-aos-delay="200">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Payment Method
                    </h2>
                    
                    <div class="space-y-4">
                        <!-- Stripe -->
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="stripe" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                                   {{ old('payment_method') === 'stripe' ? 'checked' : '' }}>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">Credit/Debit Card (Stripe)</h3>
                                        <p class="text-xs text-gray-500">Secure payment via Stripe</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <div class="w-8 h-5 bg-blue-600 rounded text-white text-xs flex items-center justify-center font-bold">VISA</div>
                                        <div class="w-8 h-5 bg-red-600 rounded text-white text-xs flex items-center justify-center font-bold">MC</div>
                                        <div class="w-8 h-5 bg-blue-500 rounded text-white text-xs flex items-center justify-center font-bold">AMEX</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <!-- PayPal -->
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="paypal" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                                   {{ old('payment_method') === 'paypal' ? 'checked' : '' }}>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900">PayPal</h3>
                                        <p class="text-xs text-gray-500">Pay with your PayPal account</p>
                                    </div>
                                    <div class="w-12 h-5 bg-blue-500 rounded text-white text-xs flex items-center justify-center font-bold">PayPal</div>
                                </div>
                            </div>
                        </label>
                        
                        <!-- Credit Card Direct -->
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="credit_card" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300"
                                   {{ old('payment_method') === 'credit_card' ? 'checked' : '' }}>
                            <div class="ml-3 flex-1">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Credit Card (Direct)</h3>
                                    <p class="text-xs text-gray-500">Pay directly with credit card</p>
                                </div>
                            </div>
                        </label>
                    </div>
                    
                    @error('payment_method')
                        <p class="form-error mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order Notes -->
                <div class="card p-6" data-aos="fade-right" data-aos-delay="400">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Notes (Optional)</h2>
                    <textarea name="notes" 
                              id="notes"
                              rows="4"
                              class="form-input @error('notes') border-red-500 @enderror"
                              placeholder="Special instructions for your order...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24" data-aos="fade-left">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                    
                    <!-- Order Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-3">
                                <img src="{{ $item->product->primary_image_url }}" 
                                     alt="{{ $item->product->name }}" 
                                     class="w-12 h-12 object-cover rounded">
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">
                                        {{ $item->product->name }}
                                    </h4>
                                    <p class="text-xs text-gray-500">
                                        Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                    </p>
                                </div>
                                
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($item->total_price, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <hr class="border-gray-200 mb-4">
                    
                    <!-- Totals -->
                    <div class="space-y-2 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-medium">
                                @if($shippingAmount > 0)
                                    ${{ number_format($shippingAmount, 2) }}
                                @else
                                    <span class="text-green-600">FREE</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">${{ number_format($taxAmount, 2) }}</span>
                        </div>
                        
                        <hr class="border-gray-200">
                        
                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total</span>
                            <span class="text-primary-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" 
                                   name="terms_accepted" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded mt-1 @error('terms_accepted') border-red-500 @enderror"
                                   {{ old('terms_accepted') ? 'checked' : '' }}
                                   required>
                            <span class="ml-2 text-sm text-gray-700">
                                I agree to the 
                                <a href="{{ route('terms') }}" target="_blank" class="text-primary-600 hover:text-primary-700 underline">Terms of Service</a>
                                and confirm that I am legally able to purchase gel blasters.
                            </span>
                        </label>
                        @error('terms_accepted')
                            <p class="form-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Place Order Button -->
                    <button type="submit" 
                            id="place-order-btn"
                            class="w-full btn-primary text-center relative">
                        <span id="btn-text">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Place Order
                        </span>
                        <span id="btn-loading" class="hidden">
                            <div class="spinner mr-2"></div>
                            Processing...
                        </span>
                    </button>
                    
                    <!-- Security Notice -->
                    <div class="mt-6 text-center">
                        <div class="flex items-center justify-center text-sm text-gray-500 mb-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            256-bit SSL Secure Checkout
                        </div>
                        <p class="text-xs text-gray-400">
                            Your payment information is encrypted and secure
                        </p>
                    </div>
                    
                    <!-- Back to Cart -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('cart.index') }}" class="text-sm text-gray-600 hover:text-gray-800 transition-colors">
                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    const btn = document.getElementById('place-order-btn');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');
    
    // Show loading state
    btn.disabled = true;
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');
    
    // Add a timeout to prevent indefinite loading
    setTimeout(() => {
        if (btn.disabled) {
            btn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
        }
    }, 30000); // 30 seconds timeout
});

// Auto-fill shipping information from profile
function fillFromProfile() {
    // This would be enhanced with AJAX call to get user profile data
    const confirmed = confirm('Fill shipping information from your profile?');
    if (confirmed) {
        // In a real implementation, this would fetch user data via AJAX
        alert('Feature coming soon! Please fill manually for now.');
    }
}

// Address validation
function validateAddress() {
    const requiredFields = [
        'shipping_first_name',
        'shipping_last_name', 
        'shipping_email',
        'shipping_address_line_1',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country'
    ];
    
    let isValid = true;
    
    requiredFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else {
            field.classList.remove('border-red-500');
        }
    });
    
    return isValid;
}

// Real-time form validation
document.querySelectorAll('input[required], select[required]').forEach(field => {
    field.addEventListener('blur', function() {
        if (this.value.trim()) {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        } else {
            this.classList.add('border-red-500');
            this.classList.remove('border-green-500');
        }
    });
    
    field.addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('border-red-500');
        }
    });
});

// Email validation
document.getElementById('shipping_email').addEventListener('blur', function() {
    const email = this.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        this.classList.add('border-red-500');
        
        // Show error message
        let errorMsg = this.parentElement.querySelector('.email-error');
        if (!errorMsg) {
            errorMsg = document.createElement('p');
            errorMsg.className = 'form-error email-error';
            errorMsg.textContent = 'Please enter a valid email address';
            this.parentElement.appendChild(errorMsg);
        }
    } else {
        this.classList.remove('border-red-500');
        const errorMsg = this.parentElement.querySelector('.email-error');
        if (errorMsg) {
            errorMsg.remove();
        }
    }
});

// Phone number formatting
document.getElementById('shipping_phone').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    if (value.length >= 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/(\d{3})(\d{3})/, '($1) $2');
    }
    this.value = value;
});

// Postal code formatting
document.getElementById('shipping_postal_code').addEventListener('input', function() {
    const country = document.getElementById('shipping_country').value;
    let value = this.value;
    
    if (country === 'US') {
        // US ZIP code format: 12345 or 12345-6789
        value = value.replace(/\D/g, '');
        if (value.length > 5) {
            value = value.substring(0, 5) + '-' + value.substring(5, 9);
        }
    } else if (country === 'CA') {
        // Canadian postal code format: A1A 1A1
        value = value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        if (value.length > 3) {
            value = value.substring(0, 3) + ' ' + value.substring(3, 6);
        }
    }
    
    this.value = value;
});

// Payment method selection enhancement
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Remove selected state from all payment methods
        document.querySelectorAll('input[name="payment_method"]').forEach(r => {
            r.closest('label').classList.remove('ring-2', 'ring-primary-500', 'border-primary-500');
        });
        
        // Add selected state to chosen payment method
        if (this.checked) {
            this.closest('label').classList.add('ring-2', 'ring-primary-500', 'border-primary-500');
        }
    });
});

// Form submission validation
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    // Check if payment method is selected
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (!paymentMethod) {
        e.preventDefault();
        alert('Please select a payment method');
        return;
    }
    
    // Check terms acceptance
    const termsAccepted = document.querySelector('input[name="terms_accepted"]:checked');
    if (!termsAccepted) {
        e.preventDefault();
        alert('Please accept the terms and conditions');
        return;
    }
    
    // Validate address
    if (!validateAddress()) {
        e.preventDefault();
        alert('Please fill in all required shipping information');
        return;
    }
});

// Auto-save form data to localStorage for recovery
function saveFormData() {
    const formData = new FormData(document.getElementById('checkout-form'));
    const data = {};
    
    for (let [key, value] of formData.entries()) {
        if (key !== '_token' && key !== 'terms_accepted') {
            data[key] = value;
        }
    }
    
    localStorage.setItem('checkout_form_data', JSON.stringify(data));
}

// Load saved form data
function loadFormData() {
    const savedData = localStorage.getItem('checkout_form_data');
    if (savedData) {
        const data = JSON.parse(savedData);
        
        Object.keys(data).forEach(key => {
            const field = document.querySelector(`[name="${key}"]`);
            if (field && !field.value) {
                field.value = data[key];
            }
        });
    }
}

// Save form data on input
document.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('input', saveFormData);
});

// Load saved data on page load
document.addEventListener('DOMContentLoaded', loadFormData);

// Clear saved data on successful submission
document.getElementById('checkout-form').addEventListener('submit', function() {
    localStorage.removeItem('checkout_form_data');
});
</script>
@endpush
@endsection