@extends('layouts.app')

@section('title', 'Email Verification')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Verify Your Email Address
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                We've sent a verification link to your email address.
            </p>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-gray-700 mb-4">
                Before getting started, could you verify your email address by clicking on the link we just emailed to you? 
                If you didn't receive the email, we will gladly send you another.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection