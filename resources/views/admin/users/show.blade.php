@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- User Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">User Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?: 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $user->date_of_birth ? $user->date_of_birth->format('M j, Y') . ' (Age: ' . $user->age . ')' : 'N/A' }}
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M j, Y') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->diffForHumans() }}</dd>
                        </div>
                    </div>
                    
                    @if($user->address_line_1)
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $user->address_line_1 }}
                                @if($user->address_line_2), {{ $user->address_line_2 }}@endif
                                <br>
                                {{ $user->city }}, {{ $user->state }} {{ $user->postal_code }}
                                <br>
                                {{ $user->country }}
                            </dd>
                        </div>
                    @endif
                </div>

                <!-- Verification Status -->
                @if($user->verification)
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Age Verification</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($user->verification->verification_status === 'pending')
                                        <span class="badge-warning">Pending Review</span>
                                    @elseif($user->verification->verification_status === 'approved')
                                        <span class="badge-success">Approved</span>
                                    @else
                                        <span class="badge-danger">Rejected</span>
                                    @endif
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Submitted</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $user->verification->created_at->format('M j, Y \a\t g:i A') }}</dd>
                            </div>
                            
                            @if($user->verification->verified_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Verified At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->verification->verified_at->format('M j, Y \a\t g:i A') }}</dd>
                                </div>
                            @endif
                            
                            @if($user->verification->rejection_reason)
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Rejection Reason</dt>
                                    <dd class="mt-1 text-sm text-red-600">{{ $user->verification->rejection_reason }}</dd>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-6 flex space-x-3">
                            <a href="{{ route('admin.verifications.download', $user->verification) }}" 
                               class="btn-outline">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download ID Document
                            </a>
                            
                            @if($user->verification->verification_status === 'pending')
                                <form method="POST" action="{{ route('admin.verifications.approve', $user->verification) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="btn-primary"
                                            onclick="return confirm('Approve this verification?')">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approve
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Recent Orders -->
                @if($user->orders->count() > 0)
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Recent Orders</h2>
                        
                        <div class="space-y-4">
                            @foreach($user->orders->take(5) as $order)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm font-medium text-gray-900">{{ $order->order_number }}</span>
                                            <span class="status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $order->created_at->format('M j, Y') }} • {{ $order->items->count() }} items
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-xs text-blue-600 hover:text-blue-700">View</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($user->orders->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.orders.index', ['search' => $user->email]) }}" class="text-sm text-blue-600 hover:text-blue-700">
                                    View all {{ $user->orders->count() }} orders
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Cart Items -->
                @if($user->cartItems->count() > 0)
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Current Cart</h2>
                        
                        <div class="space-y-4">
                            @foreach($user->cartItems as $item)
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
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Cart Total</span>
                                <span class="font-medium">${{ number_format($user->cartItems->sum('total_price'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Quick Stats -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Quick Stats</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Total Orders</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $user->orders->count() }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Total Spent</span>
                            <span class="text-lg font-semibold text-gray-900">
                                ${{ number_format($user->orders->where('payment_status', 'paid')->sum('total_amount'), 2) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Cart Items</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $user->cartItems->sum('quantity') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Average Order</span>
                            <span class="text-lg font-semibold text-gray-900">
                                ${{ $user->orders->where('payment_status', 'paid')->count() > 0 ? number_format($user->orders->where('payment_status', 'paid')->avg('total_amount'), 2) : '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Account Status</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Email Verified</span>
                            @if($user->email_verified_at)
                                <span class="badge-success">Yes</span>
                            @else
                                <span class="badge-warning">No</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Age Verified</span>
                            @if($user->is_verified)
                                <span class="badge-success">Yes</span>
                            @else
                                <span class="badge-warning">No</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Can Purchase</span>
                            @if($user->isEligibleToPurchase())
                                <span class="badge-success">Yes</span>
                            @else
                                <span class="badge-danger">No</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Quick Actions</h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.orders.index', ['search' => $user->email]) }}" 
                           class="w-full btn-outline block text-center">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            View All Orders
                        </a>
                        
                        @if($user->verification)
                            <a href="{{ route('admin.verifications.index', ['search' => $user->email]) }}" 
                               class="w-full btn-outline block text-center">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                View Verification
                            </a>
                        @endif
                        
                        <button onclick="sendNotification()" class="w-full btn-outline">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function sendNotification() {
    // This would integrate with email system
    alert('Email notification feature coming soon!');
}
</script>
@endpush
@endsection