@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">About GelBlaster Pro</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Your trusted source for premium gel blasters and tactical equipment
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <div data-aos="fade-right">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                <p class="text-gray-600 mb-4">
                    Founded in 2020, GelBlaster Pro emerged from a passion for tactical gaming and a commitment to safety. 
                    We recognized the need for a reliable source of high-quality gel blasters that prioritize both performance and safety.
                </p>
                <p class="text-gray-600 mb-4">
                    Our team consists of experienced enthusiasts who understand the importance of quality equipment in tactical gaming. 
                    We carefully curate our product selection to ensure every item meets our strict standards for safety, reliability, and performance.
                </p>
                <p class="text-gray-600">
                    Today, we serve thousands of customers across the country, providing not just products but also education, 
                    support, and a community for gel blaster enthusiasts of all levels.
                </p>
            </div>
            <div data-aos="fade-left">
                <img src="https://images.pexels.com/photos/163064/play-stone-network-networked-interactive-163064.jpeg" 
                     alt="About Us" 
                     class="rounded-lg shadow-lg">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Safety First</h3>
                <p class="text-gray-600">We prioritize safety in everything we do, from product selection to customer education.</p>
            </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality Products</h3>
                <p class="text-gray-600">Every product is carefully tested and selected for superior performance and durability.</p>
            </div>

            <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Community</h3>
                <p class="text-gray-600">Building a supportive community of responsible gel blaster enthusiasts.</p>
            </div>
        </div>
    </div>
</div>
@endsection