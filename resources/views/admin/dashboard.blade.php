@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="p-6">
    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Your existing metrics cards -->
    </div>

    <div class="container-custom py-8">
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="card p-6" data-aos="fade-up">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <p class="text-2xl font-semibold text-gray-900">${{ number_format($metrics['total_revenue'], 2) }}</p>
                        <p class="text-sm text-green-600">+${{ number_format($todayStats['revenue'], 2) }} today</p>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($metrics['total_orders']) }}</p>
                        <p class="text-sm text-blue-600">{{ $todayStats['orders'] }} today</p>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($metrics['total_users']) }}</p>
                        <p class="text-sm text-purple-600">{{ $todayStats['new_users'] }} new today</p>
                    </div>
                </div>
            </div>

            <!-- Pending Verifications -->
            <div class="card p-6" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.729-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending Verifications</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $metrics['pending_verifications'] }}</p>
                        <a href="{{ route('admin.verifications.index') }}" class="text-sm text-yellow-600 hover:text-yellow-700">Review now</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Revenue Chart -->
            <div class="card p-6" data-aos="fade-right">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Last 30 Days</h3>
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card p-6" data-aos="fade-left">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Verified Users</span>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900">{{ number_format($metrics['verified_users']) }}</span>
                            <span class="ml-2 text-xs text-gray-500">({{ round(($metrics['verified_users'] / max($metrics['total_users'], 1)) * 100, 1) }}%)</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Products in Stock</span>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900">{{ number_format($metrics['total_products'] - $metrics['out_of_stock']) }}</span>
                            <span class="ml-2 text-xs text-gray-500">of {{ $metrics['total_products'] }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Pending Orders</span>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900">{{ $metrics['pending_orders'] }}</span>
                            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="ml-2 text-xs text-blue-600 hover:text-blue-700">Review</a>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Out of Stock Items</span>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900">{{ $metrics['out_of_stock'] }}</span>
                            @if($metrics['out_of_stock'] > 0)
                                <a href="{{ route('admin.products.index', ['stock_status' => 'out_of_stock']) }}" class="ml-2 text-xs text-red-600 hover:text-red-700">View</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="card p-6" data-aos="fade-right">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm font-medium text-gray-900">{{ $order->order_number }}</span>
                                    <span class="status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $order->shipping_first_name }} {{ $order->shipping_last_name }} • 
                                    {{ $order->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-xs text-blue-600 hover:text-blue-700">View</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">No recent orders</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Products -->
            <div class="card p-6" data-aos="fade-left">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Top Products</h3>
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-600 hover:text-blue-700">View all</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                        <div class="flex items-center space-x-3">
                            <img src="{{ $product->primary_image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-10 h-10 object-cover rounded">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->total_sold }} sold</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">${{ $product->price }}</p>
                                <a href="{{ route('admin.products.show', $product) }}" class="text-xs text-blue-600 hover:text-blue-700">View</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">No sales data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4" data-aos="fade-up">
            <a href="{{ route('admin.products.create') }}" class="card p-4 hover:shadow-lg transition-shadow text-center">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-900">Add Product</span>
            </a>
            
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="card p-4 hover:shadow-lg transition-shadow text-center">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-900">Manage Orders</span>
            </a>
            
            <a href="{{ route('admin.verifications.index', ['status' => 'pending']) }}" class="card p-4 hover:shadow-lg transition-shadow text-center">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-900">Age Verifications</span>
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="card p-4 hover:shadow-lg transition-shadow text-center">
                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-900">Manage Users</span>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($revenueData);
    
    const dates = revenueData.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });
    
    const revenues = revenueData.map(item => parseFloat(item.revenue));
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Revenue',
                data: revenues,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            tooltips: {
                callbacks: {
                    label: function(context) {
                        return 'Revenue: $' + context.parsed.y.toLocaleString();
                    }
                }
            }
        }
    });
});

// Auto-refresh dashboard every 5 minutes
setInterval(function() {
    location.reload();
}, 300000);

// Real-time notifications (placeholder for WebSocket implementation)
function checkForNotifications() {
    // This would typically use WebSockets or Server-Sent Events
    // For now, we'll just check for new orders/verifications via AJAX
    fetch('/admin/notifications/check')
        .then(response => response.json())
        .then(data => {
            if (data.new_orders > 0) {
                showNotification(`${data.new_orders} new order(s) received!`, 'info');
            }
            if (data.new_verifications > 0) {
                showNotification(`${data.new_verifications} new verification(s) pending!`, 'warning');
            }
        })
        .catch(error => console.error('Error checking notifications:', error));
}

// Check for notifications every 2 minutes
setInterval(checkForNotifications, 120000);

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full notification-${type}`;
    
    notification.innerHTML = `
        <div class="flex justify-between items-center">
            <span class="text-sm">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}
</script>
@endpush
@endsection