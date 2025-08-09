@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Users</h1>
                    <p class="text-gray-600 mt-1">Manage user accounts and verification status</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="text-sm text-gray-600">
                        {{ $users->total() }} total users
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
                           placeholder="Search by name or email..." 
                           value="{{ request('search') }}"
                           class="form-input">
                </div>

                <div></div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full btn-primary">Filter</button>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="card overflow-hidden">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Contact</th>
                            <th>Orders</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                            <span class="text-primary-700 font-medium text-sm">
                                                {{ substr($user->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">
                                        @if($user->phone)
                                            <div>{{ $user->phone }}</div>
                                        @endif
                                        @if($user->city && $user->state)
                                            <div class="text-gray-500">{{ $user->city }}, {{ $user->state }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $user->orders->count() }} orders</div>
                                    <div class="text-sm text-gray-500">
                                        ${{ number_format($user->total_spent, 2) }} total
                                    </div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $user->created_at->format('M j, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-blue-600 hover:text-blue-700" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-green-600 hover:text-green-700" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-1a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <p class="text-gray-500">No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- Quick Stats -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="card p-4 text-center">
                <div class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('is_admin', false)->count() }}</div>
                <div class="text-sm text-gray-500">Total Users</div>
            </div>
            
            <div class="card p-4 text-center">
                <div class="text-2xl font-bold text-green-600">{{ \App\Models\Order::where('payment_status', 'paid')->count() }}</div>
                <div class="text-sm text-gray-500">Paid Orders</div>
            </div>
            
            <div class="card p-4 text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ \App\Models\Product::where('in_stock', false)->count() }}</div>
                <div class="text-sm text-gray-500">Out of Stock</div>
            </div>
            
            <div class="card p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ \App\Models\User::whereDate('created_at', today())->where('is_admin', false)->count() }}</div>
                <div class="text-sm text-gray-500">New Today</div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
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