@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Orders</h1>
                    <p class="text-gray-600 mt-1">Manage customer orders and fulfillment</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="text-sm text-gray-600">
                        {{ $orders->total() }} total orders
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-custom py-8">
        <!-- Filters -->
        <div class="card p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <input type="text" 
                           name="search" 
                           placeholder="Search orders..." 
                           value="{{ request('search') }}"
                           class="form-input">
                </div>

                <!-- Status Filter -->
                <div>
                    <select name="status" class="form-input">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Payment Status Filter -->
                <div>
                    <select name="payment_status" class="form-input">
                        <option value="">All Payment Status</option>
                        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <input type="date" 
                           name="date_from" 
                           value="{{ request('date_from') }}"
                           class="form-input">
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="card overflow-hidden">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $order->order_number }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->items->count() }} items</div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $order->shipping_full_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->shipping_email }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge-success">Paid</span>
                                    @elseif($order->payment_status === 'pending')
                                        <span class="badge-warning">Pending</span>
                                    @elseif($order->payment_status === 'failed')
                                        <span class="badge-danger">Failed</span>
                                    @else
                                        <span class="badge-info">{{ ucfirst($order->payment_status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</div>
                                    <div class="text-sm text-gray-500">{{ ucfirst($order->payment_method) }}</div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $order->created_at->format('M j, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->created_at->format('g:i A') }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="text-blue-600 hover:text-blue-700" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        @if($order->status === 'pending' || $order->status === 'processing')
                                            <button onclick="showStatusModal({{ $order->id }}, '{{ $order->status }}')" 
                                                    class="text-green-600 hover:text-green-700" title="Update Status">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-500">No orders found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="status-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="status-form" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Update Order Status
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Change the order status and add any relevant notes.
                                </p>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="status" class="form-label">Order Status</label>
                                    <select name="status" id="modal-status" class="form-input w-full" required>
                                        <option value="pending">Pending</option>
                                        <option value="processing">Processing</option>
                                        <option value="shipped">Shipped</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="tracking_number" class="form-label">Tracking Number (Optional)</label>
                                    <input type="text" 
                                           name="tracking_number" 
                                           id="modal-tracking"
                                           class="form-input w-full" 
                                           placeholder="Enter tracking number">
                                </div>
                                
                                <div>
                                    <label for="notes" class="form-label">Notes (Optional)</label>
                                    <textarea name="notes" 
                                              id="modal-notes"
                                              rows="3" 
                                              class="form-input w-full" 
                                              placeholder="Add any notes about this status change..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Status
                    </button>
                    <button type="button" onclick="hideStatusModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showStatusModal(orderId, currentStatus) {
    const modal = document.getElementById('status-modal');
    const form = document.getElementById('status-form');
    const statusSelect = document.getElementById('modal-status');
    
    form.action = `/admin/orders/${orderId}`;
    statusSelect.value = currentStatus;
    modal.classList.remove('hidden');
}

function hideStatusModal() {
    const modal = document.getElementById('status-modal');
    modal.classList.add('hidden');
    
    // Clear form
    document.getElementById('modal-status').value = '';
    document.getElementById('modal-tracking').value = '';
    document.getElementById('modal-notes').value = '';
}

// Close modal when clicking outside
document.getElementById('status-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideStatusModal();
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