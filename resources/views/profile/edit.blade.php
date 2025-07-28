@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8" data-aos="fade-up">
                <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
                <p class="text-gray-600 mt-2">Manage your account information and preferences</p>
            </div>

            <div class="space-y-6">
                <!-- Profile Information -->
                <div class="card p-8" data-aos="fade-up">
                    <div class="max-w-xl">
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Profile Information
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Update your account's profile information and email address.
                            </p>
                        </header>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label for="name" class="form-label">Name</label>
                                <input id="name" name="name" type="text" class="form-input @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                                @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-input @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                                @error('email')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-800">
                                            Your email address is unverified.
                                            <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Click here to re-send the verification email.
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                A new verification link has been sent to your email address.
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Additional Profile Fields -->
                            <div>
                                <label for="phone" class="form-label">Phone Number</label>
                                <input id="phone" name="phone" type="tel" class="form-input @error('phone') border-red-500 @enderror" value="{{ old('phone', $user->phone) }}" autocomplete="tel" />
                                @error('phone')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="address_line_1" class="form-label">Address Line 1</label>
                                    <input id="address_line_1" name="address_line_1" type="text" class="form-input @error('address_line_1') border-red-500 @enderror" value="{{ old('address_line_1', $user->address_line_1) }}" />
                                    @error('address_line_1')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="address_line_2" class="form-label">Address Line 2</label>
                                    <input id="address_line_2" name="address_line_2" type="text" class="form-input @error('address_line_2') border-red-500 @enderror" value="{{ old('address_line_2', $user->address_line_2) }}" />
                                    @error('address_line_2')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="city" class="form-label">City</label>
                                    <input id="city" name="city" type="text" class="form-input @error('city') border-red-500 @enderror" value="{{ old('city', $user->city) }}" />
                                    @error('city')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="state" class="form-label">State</label>
                                    <input id="state" name="state" type="text" class="form-input @error('state') border-red-500 @enderror" value="{{ old('state', $user->state) }}" />
                                    @error('state')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input id="postal_code" name="postal_code" type="text" class="form-input @error('postal_code') border-red-500 @enderror" value="{{ old('postal_code', $user->postal_code) }}" />
                                    @error('postal_code')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="country" class="form-label">Country</label>
                                <select id="country" name="country" class="form-input @error('country') border-red-500 @enderror">
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

                            <div class="flex items-center gap-4">
                                <button type="submit" class="btn-primary">Save Changes</button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600">
                                        Saved successfully!
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card p-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="max-w-xl">
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Update Password
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Ensure your account is using a long, random password to stay secure.
                            </p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password" class="form-label">Current Password</label>
                                <input id="update_password_current_password" name="current_password" type="password" class="form-input @error('current_password', 'updatePassword') border-red-500 @enderror" autocomplete="current-password" />
                                @error('current_password', 'updatePassword')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="update_password_password" class="form-label">New Password</label>
                                <input id="update_password_password" name="password" type="password" class="form-input @error('password', 'updatePassword') border-red-500 @enderror" autocomplete="new-password" />
                                @error('password', 'updatePassword')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-input @error('password_confirmation', 'updatePassword') border-red-500 @enderror" autocomplete="new-password" />
                                @error('password_confirmation', 'updatePassword')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="btn-primary">Update Password</button>

                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600">
                                        Password updated successfully!
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card p-8" data-aos="fade-up" data-aos-delay="400">
                    <div class="max-w-xl">
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Delete Account
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                            </p>
                        </header>

                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                            Delete Account
                        </button>

                        <!-- Delete Account Modal -->
                        <div x-data="{ show: false }" x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null" x-on:close-modal.window="$event.detail == 'confirm-user-deletion' ? show = false : null" x-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: none;">
                            <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>

                            <div x-show="show" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md sm:mx-auto">
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                    @csrf
                                    @method('delete')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Are you sure you want to delete your account?
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600">
                                        Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                                    </p>

                                    <div class="mt-6">
                                        <label for="password" class="sr-only">Password</label>
                                        <input id="password" name="password" type="password" class="form-input" placeholder="Password" />
                                        @error('password', 'userDeletion')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mt-6 flex justify-end space-x-3">
                                        <button type="button" x-on:click="show = false" class="btn-secondary">
                                            Cancel
                                        </button>
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                                            Delete Account
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection