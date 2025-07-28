@extends('layouts.app')

@section('title', 'Age Verification')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8" data-aos="fade-up">
            <div class="mx-auto h-16 w-16 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Age Verification Required</h1>
            <p class="text-xl text-gray-600">
                To purchase gel blasters, you must verify that you are 18 years or older
            </p>
        </div>

        @if($verification)
            <!-- Existing Verification Status -->
            <div class="card p-8 mb-8" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center">
                    @if($verification->verification_status === 'pending')
                        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Verification Pending</h2>
                        <p class="text-gray-600 mb-6">
                            Your ID verification is currently being reviewed. This typically takes 24-48 hours during business days.
                        </p>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800">
                                <strong>Submitted:</strong> {{ $verification->created_at->format('M j, Y \a\t g:i A') }}
                            </p>
                        </div>
                    @elseif($verification->verification_status === 'approved')
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Verification Approved!</h2>
                        <p class="text-gray-600 mb-6">
                            Your age has been successfully verified. You can now purchase gel blasters and accessories.
                        </p>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-sm text-green-800">
                                <strong>Verified:</strong> {{ $verification->verified_at->format('M j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" class="btn-primary">
                                Start Shopping
                            </a>
                        </div>
                    @else
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-4">Verification Rejected</h2>
                        <p class="text-gray-600 mb-6">
                            Unfortunately, your verification was rejected. Please review the reason below and resubmit with a clear, valid ID.
                        </p>
                        @if($verification->rejection_reason)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <p class="text-sm text-red-800">
                                    <strong>Reason:</strong> {{ $verification->rejection_reason }}
                                </p>
                            </div>
                        @endif
                        <div class="mt-6">
                            <p class="text-sm text-gray-600 mb-4">You can resubmit your verification below.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if(!$verification || $verification->verification_status === 'rejected')
            <!-- Verification Form -->
            <div class="card p-8" data-aos="fade-up" data-aos-delay="300">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Upload Your ID</h2>
                
                <!-- Requirements -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-blue-900 mb-4">ID Requirements:</h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Government-issued photo ID (Driver's License, Passport, State ID)
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Must be current and not expired
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Clear, high-quality image or scan
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            All text must be clearly readable
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            File formats: JPEG, PNG, or PDF (max 5MB)
                        </li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('verification.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input id="date_of_birth" 
                               name="date_of_birth" 
                               type="date" 
                               required 
                               class="form-input @error('date_of_birth') border-red-500 @enderror"
                               value="{{ old('date_of_birth', auth()->user()->date_of_birth?->format('Y-m-d')) }}">
                        <p class="mt-1 text-sm text-gray-500">This should match the date of birth on your ID</p>
                        @error('date_of_birth')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ID Document Upload -->
                    <div>
                        <label for="id_document" class="form-label">ID Document</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors @error('id_document') border-red-500 @enderror">
                            <div class="space-y-1 text-center">
                                <div id="file-upload-icon">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="flex text-sm text-gray-600">
                                    <label for="id_document" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        <span>Upload a file</span>
                                        <input id="id_document" 
                                               name="id_document" 
                                               type="file" 
                                               class="sr-only" 
                                               accept=".jpg,.jpeg,.png,.pdf"
                                               required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">JPEG, PNG, PDF up to 5MB</p>
                                <div id="file-name" class="hidden text-sm text-gray-700 font-medium"></div>
                            </div>
                        </div>
                        @error('id_document')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Privacy Notice -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-800">Privacy & Security</h3>
                                <div class="mt-2 text-sm text-gray-600">
                                    <p>Your ID information is encrypted and stored securely. We only use it for age verification purposes and will never share it with third parties. Documents are automatically deleted after verification.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full btn-primary flex justify-center items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Submit for Verification
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Help Section -->
        <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="400">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Need Help?</h3>
            <p class="text-gray-600 mb-4">If you're having trouble with the verification process, our support team is here to help.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="btn-outline">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Contact Support
                </a>
                <a href="#faq" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    View FAQ
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-12" id="faq" data-aos="fade-up" data-aos-delay="500">
            <div class="card p-8">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6">Frequently Asked Questions</h3>
                
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-4">
                        <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(1)">
                            <h4 class="text-lg font-medium text-gray-900">Why do I need to verify my age?</h4>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hidden mt-4 text-gray-600" id="faq-content-1">
                            <p>Gel blasters are regulated products that require purchasers to be 18 years or older. This verification process ensures compliance with local laws and regulations, and helps promote responsible ownership.</p>
                        </div>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(2)">
                            <h4 class="text-lg font-medium text-gray-900">What documents are accepted?</h4>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hidden mt-4 text-gray-600" id="faq-content-2">
                            <p>We accept government-issued photo IDs including:</p>
                            <ul class="list-disc list-inside mt-2 space-y-1">
                                <li>Driver's License</li>
                                <li>State-issued ID Card</li>
                                <li>Passport</li>
                                <li>Military ID</li>
                            </ul>
                            <p class="mt-2">The document must be current, not expired, and show your date of birth clearly.</p>
                        </div>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(3)">
                            <h4 class="text-lg font-medium text-gray-900">How long does verification take?</h4>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hidden mt-4 text-gray-600" id="faq-content-3">
                            <p>Most verifications are completed within 24-48 hours during business days (Monday-Friday). Complex cases may take up to 3-5 business days. You'll receive an email notification once your verification is complete.</p>
                        </div>
                    </div>

                    <div class="border-b border-gray-200 pb-4">
                        <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(4)">
                            <h4 class="text-lg font-medium text-gray-900">Is my personal information secure?</h4>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hidden mt-4 text-gray-600" id="faq-content-4">
                            <p>Absolutely. We use bank-level encryption to protect your data. Your ID documents are stored securely and are only accessible to authorized verification staff. We never share your information with third parties, and documents are automatically deleted after successful verification.</p>
                        </div>
                    </div>

                    <div>
                        <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(5)">
                            <h4 class="text-lg font-medium text-gray-900">What if my verification is rejected?</h4>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hidden mt-4 text-gray-600" id="faq-content-5">
                            <p>If your verification is rejected, you'll receive a detailed explanation of the reason. Common reasons include blurry images, expired documents, or mismatched information. You can resubmit a new verification request with corrected documents at any time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// File upload handling
document.getElementById('id_document').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
        
        // Update UI to show selected file
        document.getElementById('file-upload-icon').innerHTML = `
            <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        `;
        
        document.getElementById('file-name').innerHTML = `
            <p class="text-green-600 font-medium">${fileName}</p>
            <p class="text-gray-500 text-xs">${fileSize} MB</p>
        `;
        document.getElementById('file-name').classList.remove('hidden');
        
        // Validate file size
        if (file.size > 5 * 1024 * 1024) { // 5MB
            alert('File size must be less than 5MB');
            this.value = '';
            resetFileUpload();
        }
    }
});

function resetFileUpload() {
    document.getElementById('file-upload-icon').innerHTML = `
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    `;
    document.getElementById('file-name').classList.add('hidden');
}

// Drag and drop handling
const dropArea = document.querySelector('[data-upload-area]') || document.querySelector('.border-dashed');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropArea.classList.add('border-primary-500', 'bg-primary-50');
}

function unhighlight(e) {
    dropArea.classList.remove('border-primary-500', 'bg-primary-50');
}

dropArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        document.getElementById('id_document').files = files;
        document.getElementById('id_document').dispatchEvent(new Event('change'));
    }
}

// FAQ toggle functionality
function toggleFAQ(number) {
    const content = document.getElementById(`faq-content-${number}`);
    const icon = document.getElementById(`faq-icon-${number}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Age validation
document.getElementById('date_of_birth').addEventListener('change', function() {
    const dob = new Date(this.value);
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    
    const existingError = this.parentElement.querySelector('.age-error');
    if (existingError) {
        existingError.remove();
    }
    
    if (age < 18) {
        const error = document.createElement('p');
        error.className = 'form-error age-error';
        error.textContent = 'You must be at least 18 years old to purchase gel blasters.';
        this.parentElement.appendChild(error);
        this.classList.add('border-red-500');
    } else {
        this.classList.remove('border-red-500');
    }
});
</script>
@endpush
@endsection