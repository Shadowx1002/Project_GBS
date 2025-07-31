@extends('layouts.app')

@section('title', 'Verification Details')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Age Verification Review</h1>
                    <p class="text-gray-600 mt-1">{{ $verification->user->name }} ({{ $verification->user->email }})</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.show', $verification->user) }}" class="btn-outline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View User
                    </a>
                    <a href="{{ route('admin.verifications.index') }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Verifications
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Verification Details -->
            <div class="space-y-6">
                <!-- User Information -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">User Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $verification->user->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $verification->user->email }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $verification->user->phone ?: 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $verification->user->created_at->format('M j, Y') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Verification Information -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Verification Details</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if($verification->verification_status === 'pending')
                                    <span class="badge-warning">Pending Review</span>
                                @elseif($verification->verification_status === 'approved')
                                    <span class="badge-success">Approved</span>
                                @else
                                    <span class="badge-danger">Rejected</span>
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $verification->date_of_birth->format('M j, Y') }} 
                                (Age: {{ $verification->date_of_birth->age }})
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Submitted</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $verification->created_at->format('M j, Y \a\t g:i A') }}</dd>
                        </div>
                        
                        @if($verification->verified_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Verified At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $verification->verified_at->format('M j, Y \a\t g:i A') }}</dd>
                            </div>
                        @endif
                    </div>
                    
                    @if($verification->rejection_reason)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">Rejection Reason</dt>
                            <dd class="mt-1 text-sm text-red-600 bg-red-50 p-3 rounded-lg">{{ $verification->rejection_reason }}</dd>
                        </div>
                    @endif
                </div>

                <!-- ID Document -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">ID Document</h2>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Government ID Document</p>
                                    <p class="text-sm text-gray-500">Uploaded {{ $verification->created_at->diffForHumans() }}</p>
                                </div>
                                <a href="{{ route('admin.verifications.download', $verification) }}" 
                                   class="btn-outline">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Document
                                </a>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">Verification Checklist:</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>✓ Document is government-issued photo ID</li>
                                <li>✓ Document is current and not expired</li>
                                <li>✓ All text is clearly readable</li>
                                <li>✓ Date of birth matches submitted information</li>
                                <li>✓ Person is 18 years or older</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Panel -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Actions</h2>
                    
                    @if($verification->verification_status === 'pending')
                        <div class="space-y-4">
                            <!-- Approve Button -->
                            <form method="POST" action="{{ route('admin.verifications.approve', $verification) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full btn-primary"
                                        onclick="return confirm('Approve this age verification? This will allow the user to purchase products.')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approve Verification
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <button onclick="showRejectModal()" 
                                    class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject Verification
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 {{ $verification->verification_status === 'approved' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center mx-auto mb-4">
                                @if($verification->verification_status === 'approved')
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                @endif
                            </div>
                            <p class="text-gray-600">
                                This verification has been {{ $verification->verification_status }}.
                            </p>
                        </div>
                    @endif

                    <!-- Quick Links -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.users.show', $verification->user) }}" 
                               class="block text-blue-600 hover:text-blue-700 text-sm">
                                View User Profile
                            </a>
                            <a href="{{ route('admin.orders.index', ['search' => $verification->user->email]) }}" 
                               class="block text-blue-600 hover:text-blue-700 text-sm">
                                View User Orders
                            </a>
                            <a href="{{ route('admin.verifications.download', $verification) }}" 
                               class="block text-blue-600 hover:text-blue-700 text-sm">
                                Download ID Document
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="reject-form" method="POST" action="{{ route('admin.verifications.reject', $verification) }}">
                @csrf
                @method('PATCH')
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.729-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Reject Age Verification
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Please provide a detailed reason for rejecting this verification. This will be sent to the user via email.
                                </p>
                            </div>
                            <div class="mt-4">
                                <textarea name="rejection_reason" 
                                          rows="4" 
                                          class="form-input w-full" 
                                          placeholder="Reason for rejection (e.g., 'Document is blurry and unreadable', 'ID appears to be expired', etc.)"
                                          required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Reject Verification
                    </button>
                    <button type="button" onclick="hideRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showRejectModal() {
    document.getElementById('reject-modal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
    document.querySelector('textarea[name="rejection_reason"]').value = '';
}

// Close modal when clicking outside
document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endpush
@endsection