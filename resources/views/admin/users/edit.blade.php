@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container-custom py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
                    <p class="text-gray-600 mt-1">{{ $user->name }} ({{ $user->email }})</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.show', $user) }}" class="btn-outline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View User
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
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-4xl mx-auto">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Basic Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-input @error('name') border-red-500 @enderror"
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       class="form-input @error('email') border-red-500 @enderror"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" 
                                       name="phone" 
                                       id="phone"
                                       class="form-input @error('phone') border-red-500 @enderror"
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Address Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="address_line_1" class="form-label">Address Line 1</label>
                                <input type="text" 
                                       name="address_line_1" 
                                       id="address_line_1"
                                       class="form-input @error('address_line_1') border-red-500 @enderror"
                                       value="{{ old('address_line_1', $user->address_line_1) }}">
                                @error('address_line_1')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address_line_2" class="form-label">Address Line 2</label>
                                <input type="text" 
                                       name="address_line_2" 
                                       id="address_line_2"
                                       class="form-input @error('address_line_2') border-red-500 @enderror"
                                       value="{{ old('address_line_2', $user->address_line_2) }}">
                                @error('address_line_2')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" 
                                           name="city" 
                                           id="city"
                                           class="form-input @error('city') border-red-500 @enderror"
                                           value="{{ old('city', $user->city) }}">
                                    @error('city')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" 
                                           name="state" 
                                           id="state"
                                           class="form-input @error('state') border-red-500 @enderror"
                                           value="{{ old('state', $user->state) }}">
                                    @error('state')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="text" 
                                           name="postal_code" 
                                           id="postal_code"
                                           class="form-input @error('postal_code') border-red-500 @enderror"
                                           value="{{ old('postal_code', $user->postal_code) }}">
                                    @error('postal_code')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="country" class="form-label">Country</label>
                                <select name="country" 
                                        id="country"
                                        class="form-input @error('country') border-red-500 @enderror">
                                    <option value="">Select Country</option>
                                    <option value="US" {{ old('country', $user->country) === 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country', $user->country) === 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="AU" {{ old('country', $user->country) === 'AU' ? 'selected' : '' }}>Australia</option>
                                    <option value="UK" {{ old('country', $user->country) === 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                </select>
                                @error('country')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Verification Status -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Verification Status</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="is_verified" 
                                       id="is_verified"
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                       {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}>
                                <label for="is_verified" class="ml-2 text-sm text-gray-700">
                                    Age verified (can purchase products)
                                </label>
                            </div>
                            
                            @if($user->verification)
                                <div class="text-sm text-gray-600">
                                    <p><strong>Verification Status:</strong> {{ ucfirst($user->verification->verification_status) }}</p>
                                    <p><strong>Submitted:</strong> {{ $user->verification->created_at->format('M j, Y') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card p-6">
                        <div class="space-y-3">
                            <button type="submit" class="w-full btn-primary">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update User
                            </button>
                            
                            <a href="{{ route('admin.users.show', $user) }}" class="w-full btn-outline block text-center">
                                Cancel
                            </a>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="card p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Account Info</h2>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">User ID:</span>
                                <span class="text-gray-900">{{ $user->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Created:</span>
                                <span class="text-gray-900">{{ $user->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Last Login:</span>
                                <span class="text-gray-900">{{ $user->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection