@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12" data-aos="fade-up">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
                <p class="text-xl text-gray-600">
                    Last updated: {{ date('F j, Y') }}
                </p>
            </div>

            <div class="card p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="prose prose-lg max-w-none">
                    <h2>Information We Collect</h2>
                    <p>We collect information you provide directly to us, such as when you create an account, make a purchase, or contact us.</p>

                    <h2>How We Use Your Information</h2>
                    <p>We use the information we collect to:</p>
                    <ul>
                        <li>Process transactions and send related information</li>
                        <li>Verify your age for legal compliance</li>
                        <li>Send you technical notices and support messages</li>
                        <li>Respond to your comments and questions</li>
                    </ul>

                    <h2>Information Sharing</h2>
                    <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>

                    <h2>Data Security</h2>
                    <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

                    <h2>Age Verification Data</h2>
                    <p>ID documents submitted for age verification are encrypted, securely stored, and automatically deleted after successful verification.</p>

                    <h2>Contact Us</h2>
                    <p>If you have questions about this Privacy Policy, please contact us at privacy@gelblasterpro.com.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection