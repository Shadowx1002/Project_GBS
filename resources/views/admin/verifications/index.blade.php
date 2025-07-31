@extends('layouts.app')

@section('title', 'Age Verifications')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Age Verifications</h1>
                    <p class="text-gray-600 mt-1">Review and manage user age verification requests</p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        {{ $verifications->total() }} total verifications
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <!-- Filters -->
        <div class="card p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <input type="text" 
                           name="search" 
                           placeholder="Search by user name or email..." 
                           value="{{ request('search') }}"
                           class="form-input">
                </div>

                <!-- Status Filter -->
                <div>
                    <select name="status" class="form-input">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <!-- Verifications Table -->
        <div class="card overflow-hidden">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Date of Birth</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($verifications as $verification)
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                            <span class="text-primary-700 font-medium text-sm">
                                                {{ substr($verification->user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $verification->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $verification->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $verification->date_of_birth->format('M j, Y') }}</div>
                                    <div class="text-sm text-gray-500">
                                        Age: {{ $verification->date_of_birth->age }} years
                                    </div>
                                </td>
                                <td>
                                    @if($verification->verification_status === 'pending')
                                        <span class="badge-warning">Pending</span>
                                    @elseif($verification->verification_status === 'approved')
                                        <span class="badge-success">Approved</span>
                                    @else
                                        <span class="badge-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $verification->created_at->format('M j, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $verification->created_at->format('g:i A') }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <!-- Download Document -->
                                        <a href="{{ route('admin.verifications.download', $verification) }}" 
                                           class="text-blue-600 hover:text-blue-700" 
                                           title="Download ID Document">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </a>

                                        <!-- View Details -->
                                        <a href="{{ route('admin.verifications.show', $verification) }}" 
                                           class="text-purple-600 hover:text-purple-700" 
                                           title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        @if($verification->verification_status === 'pending')
                                            <!-- Approve -->
                                            <form method="POST" action="{{ route('admin.verifications.approve', $verification) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="text-green-600 hover:text-green-700" 
                                                        title="Approve"
                                                        onclick="return confirm('Approve this verification?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- Reject -->
                                            <button onclick="showRejectModal({{ $verification->id }})" 
                                                    class="text-red-600 hover:text-red-700" 
                                                    title="Reject">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @endif

                                        <!-- View User -->
                                        <a href="{{ route('admin.users.show', $verification->user) }}" 
                                           class="text-purple-600 hover:text-purple-700" 
                                           title="View User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-gray-500">No verifications found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($verifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $verifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="reject-form" method="POST">
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
                                Reject Verification
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Please provide a reason for rejecting this verification. This will be sent to the user.
                                </p>
                            </div>
                            <div class="mt-4">
                                <textarea name="rejection_reason" 
                                          rows="4" 
                                          class="form-input w-full" 
                                          placeholder="Reason for rejection..."
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
function showRejectModal(verificationId) {
    const modal = document.getElementById('reject-modal');
    const form = document.getElementById('reject-form');
    
    form.action = `/admin/verifications/${verificationId}/reject`;
    modal.classList.remove('hidden');
}

function hideRejectModal() {
    const modal = document.getElementById('reject-modal');
    modal.classList.add('hidden');
    
    // Clear form
    document.querySelector('textarea[name="rejection_reason"]').value = '';
}

// Close modal when clicking outside
document.getElementById('reject-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});

// Enhanced search with debouncing
let searchTimeout;
document.querySelector('input[name="search"]').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        if (this.value.length >= 3 || this.value.length === 0) {
            this.form.submit();
        }
    }, 500);
});
</script>
@endpush
@endsection