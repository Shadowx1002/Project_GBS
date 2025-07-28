@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12" data-aos="fade-up">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Terms of Service</h1>
                <p class="text-xl text-gray-600">
                    Last updated: {{ date('F j, Y') }}
                </p>
            </div>

            <div class="card p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="prose prose-lg max-w-none">
                    <h2>1. Acceptance of Terms</h2>
                    <p>By accessing and using GelBlaster Pro, you accept and agree to be bound by the terms and provision of this agreement.</p>

                    <h2>2. Age Verification</h2>
                    <p>You must be at least 18 years old to purchase gel blasters from our store. Age verification is required and mandatory for all purchases.</p>

                    <h2>3. Product Use and Safety</h2>
                    <p>Gel blasters are recreational products that must be used responsibly. Users must:</p>
                    <ul>
                        <li>Always wear appropriate protective gear</li>
                        <li>Use products only in designated areas</li>
                        <li>Follow all local laws and regulations</li>
                        <li>Never modify products in unsafe ways</li>
                    </ul>

                    <h2>4. Privacy Policy</h2>
                    <p>Your privacy is important to us. We collect and use information in accordance with our Privacy Policy.</p>

                    <h2>5. Limitation of Liability</h2>
                    <p>GelBlaster Pro shall not be liable for any damages arising from the use or misuse of our products.</p>

                    <h2>6. Contact Information</h2>
                    <p>If you have any questions about these Terms, please contact us at support@gelblasterpro.com.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection