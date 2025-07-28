@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container-custom">
        <div class="text-center mb-12" data-aos="fade-up">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Get in touch with our team for support, questions, or feedback
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="card p-8" data-aos="fade-right">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Send us a message</h2>
                
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-input" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" required>
                    </div>
                    
                    <div>
                        <label class="form-label">Subject</label>
                        <select class="form-input">
                            <option>General Inquiry</option>
                            <option>Product Support</option>
                            <option>Order Issue</option>
                            <option>Age Verification</option>
                            <option>Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="form-label">Message</label>
                        <textarea rows="5" class="form-input" required></textarea>
                    </div>
                    
                    <button type="submit" class="w-full btn-primary">Send Message</button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8" data-aos="fade-left">
                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Get in Touch</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>support@gelblasterpro.com</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>1-800-GEL-BLAST</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>123 Tactical Street, Gaming City, GC 12345</span>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Business Hours</h3>
                    <div class="space-y-2 text-gray-600">
                        <div class="flex justify-between">
                            <span>Monday - Friday</span>
                            <span>9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Saturday</span>
                            <span>10:00 AM - 4:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Sunday</span>
                            <span>Closed</span>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Quick Links</h3>
                    <div class="space-y-2">
                        <a href="#" class="block text-primary-600 hover:text-primary-700">Shipping Information</a>
                        <a href="#" class="block text-primary-600 hover:text-primary-700">Return Policy</a>
                        <a href="#" class="block text-primary-600 hover:text-primary-700">Safety Guidelines</a>
                        <a href="#" class="block text-primary-600 hover:text-primary-700">Age Verification FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection