@extends('layouts.app')

@section('title', 'Premium Gel Blasters & Accessories')

@section('content')
<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Video/Image -->
    <div class="absolute inset-0 z-0">
        <div class="hero-gradient absolute inset-0 opacity-90"></div>
        <div class="absolute inset-0 bg-pattern opacity-20"></div>
        <!-- Animated Background Elements -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-bounce-slow"></div>
        
        <!-- Tactical Grid Overlay -->
        <div class="tactical-grid"></div>
        
        <!-- Floating Particles -->
        <div id="particles-container" class="absolute inset-0"></div>
        
        <!-- Bullet Trail Effects -->
        <div id="bullet-container" class="absolute inset-0 pointer-events-none"></div>
        
        <!-- Muzzle Flash Effects -->
        <div class="absolute top-1/3 left-10 opacity-0" id="muzzle-flash-1">
            <div class="w-8 h-8 bg-yellow-400 rounded-full blur-sm animate-ping"></div>
        </div>
        <div class="absolute bottom-1/3 right-10 opacity-0" id="muzzle-flash-2">
            <div class="w-6 h-6 bg-orange-400 rounded-full blur-sm animate-ping"></div>
        </div>
        
        <!-- Crosshair Overlay -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20">
            <div class="relative">
                <div class="w-8 h-0.5 bg-white absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                <div class="w-0.5 h-8 bg-white absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                <div class="w-16 h-16 border border-white rounded-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
            </div>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-4" data-aos="fade-up">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 gradient-text">
            <span class="block">Premium</span>
            <span class="block">Gel Blasters</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-gray-200 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Experience the thrill of tactical gaming with our professional-grade gel blasters. Safe, legal, and incredibly fun.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ route('products.index') }}" class="btn-primary text-lg px-8 py-4 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Shop Now
            </a>
            <button onclick="triggerFireEffect()" class="btn-outline text-lg px-8 py-4 inline-flex items-center border-white text-white hover:bg-white hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Fire Demo
            </button>
        </div>

        <!-- Age Verification Notice -->
        <div class="mt-8 text-sm text-gray-300" data-aos="fade-up" data-aos-delay="600">
            <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2">
                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.729-.833-2.5 0L4.732 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span>18+ Age verification required for all purchases</span>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce" onclick="document.getElementById('featured').scrollIntoView({behavior: 'smooth'})">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Featured Products Section -->
<section class="section-padding bg-white" id="featured">
    <div class="container-custom">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Featured Products</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover our most popular gel blasters, chosen by enthusiasts worldwide
            </p>
        </div>

        <div class="product-grid">
            @forelse($featuredProducts as $product)
                <div class="card-product" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="product-image-container relative">
                        <img src="{{ $product->primary_image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-64 object-cover transition-transform duration-300 hover:scale-110">
                        
                        @if($product->isOnSale())
                            <div class="discount-badge">
                                -{{ $product->discount_percentage }}%
                            </div>
                        @endif

                        @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                            <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                Only {{ $product->stock_quantity }} left
                            </div>
                        @endif

                        <!-- Quick View Overlay -->
                        <div class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="bg-white text-gray-900 px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                                Quick View
                            </a>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="mb-2">
                            <span class="text-sm text-primary-600 font-medium">{{ $product->category->name }}</span>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-primary-600 transition-colors">
                                {{ $product->name }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                @if($product->isOnSale())
                                    <span class="price-sale">${{ $product->sale_price }}</span>
                                    <span class="price-original text-sm">${{ $product->price }}</span>
                                @else
                                    <span class="price-current">${{ $product->price }}</span>
                                @endif
                            </div>
                            
                            @auth
                                @if(auth()->user()->isEligibleToPurchase())
                                    @if($product->canPurchase())
                                        <button onclick="addToCart({{ $product->id }})" 
                                                class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                                            Add to Cart
                                        </button>
                                    @else
                                        <span class="text-red-500 text-sm font-medium">Out of Stock</span>
                                    @endif
                                @else
                                    <a href="{{ route('verification.show') }}" 
                                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors text-sm">
                                        Verify Age
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                                    Login to Buy
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No featured products yet</h3>
                    <p class="text-gray-600">Check back soon for amazing deals!</p>
                </div>
            @endforelse
        </div>

        @if($featuredProducts->count() > 0)
            <div class="text-center mt-12" data-aos="fade-up">
                <a href="{{ route('products.index') }}" class="btn-outline">
                    View All Products
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Categories Section -->
<section class="section-padding bg-gray-100">
    <div class="container-custom">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Shop by Category</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Find the perfect gear for your tactical gaming needs
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <div class="card group cursor-pointer" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <a href="{{ route('products.index') }}?category={{ $category->slug }}" class="block">
                        <div class="relative overflow-hidden rounded-t-xl">
                            <img src="{{ $category->image_url }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($category->description, 80) }}</p>
                            <div class="flex items-center text-primary-600 group-hover:text-primary-700">
                                <span class="text-sm font-medium">Shop Now</span>
                                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section-padding bg-white" id="features">
    <div class="container-custom">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose GelBlaster Pro?</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                We're committed to providing the best gel blaster experience with safety and quality as our top priorities
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- Feature 1 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 hover:bg-primary-200 transition-colors cursor-pointer transform hover:scale-110 duration-300">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Safety First</h3>
                <p class="text-gray-600">All our products meet strict safety standards. We provide comprehensive safety guidelines and protective gear recommendations.</p>
            </div>

            <!-- Feature 2 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 hover:bg-primary-200 transition-colors cursor-pointer transform hover:scale-110 duration-300">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Premium Quality</h3>
                <p class="text-gray-600">Hand-selected products from trusted manufacturers. Every gel blaster undergoes rigorous quality testing before shipping.</p>
            </div>

            <!-- Feature 3 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 hover:bg-primary-200 transition-colors cursor-pointer transform hover:scale-110 duration-300">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Expert Support</h3>
                <p class="text-gray-600">Our team of gel blaster enthusiasts provides technical support, maintenance tips, and gameplay advice.</p>
            </div>

            <!-- Feature 4 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 hover:bg-primary-200 transition-colors cursor-pointer transform hover:scale-110 duration-300">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Best Prices</h3>
                <p class="text-gray-600">Competitive pricing with regular promotions. We price-match and offer bulk discounts for teams and events.</p>
            </div>

            <!-- Feature 5 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="500">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 hover:bg-primary-200 transition-colors cursor-pointer transform hover:scale-110 duration-300">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Fast Shipping</h3>
                <p class="text-gray-600">Quick and secure shipping with tracking. Free shipping on orders over $100 within the continental US.</p>
            </div>

            <!-- Feature 6 -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="600">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 hover:bg-primary-200 transition-colors cursor-pointer transform hover:scale-110 duration-300">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Community</h3>
                <p class="text-gray-600">Join our growing community of gel blaster enthusiasts. Access exclusive events, tournaments, and gameplay tips.</p>
            </div>
        </div>
        
        <!-- Interactive Demo Section -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-8 text-white relative overflow-hidden" data-aos="fade-up">
            <div class="absolute inset-0 bg-pattern opacity-10"></div>
            <div class="relative z-10 text-center">
                <h3 class="text-2xl font-bold mb-4">Experience the Action</h3>
                <p class="text-gray-300 mb-6">Click anywhere on the hero section above or press SPACE to see our firing effects demo</p>
                <div class="flex justify-center space-x-4">
                    <button onclick="triggerFireEffect()" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition-colors">
                        Trigger Burst Fire
                    </button>
                    <button onclick="firingSystem.randomFire()" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                        Single Shot
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="section-padding bg-gradient-to-r from-primary-600 to-primary-800">
    <div class="container-custom">
        <div class="max-w-2xl mx-auto text-center" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-white mb-4">Stay Updated</h2>
            <p class="text-xl text-primary-100 mb-8">
                Get the latest news, product updates, and exclusive offers delivered to your inbox
            </p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto" action="#" method="POST">
                @csrf
                <input type="email" 
                       name="email" 
                       placeholder="Enter your email" 
                       class="flex-1 px-4 py-3 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-white/50"
                       required>
                <button type="submit" 
                        class="bg-white text-primary-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                    Subscribe
                </button>
            </form>
            
            <p class="text-sm text-primary-200 mt-4">
                We respect your privacy. Unsubscribe at any time.
            </p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Enhanced Firing Effects System
class FiringEffectsSystem {
    constructor() {
        this.bulletContainer = document.getElementById('bullet-container');
        this.particlesContainer = document.getElementById('particles-container');
        this.isAutoFiring = false;
        this.autoFireInterval = null;
        
        this.init();
    }
    
    init() {
        this.createFloatingParticles();
        this.startAutoFiring();
        
        // Add click listeners for manual firing
        document.addEventListener('click', (e) => {
            if (e.target.closest('.hero-gradient')) {
                this.createBulletTrail(e.clientX, e.clientY);
            }
        });
    }
    
    createFloatingParticles() {
        for (let i = 0; i < 20; i++) {
            setTimeout(() => {
                this.createParticle();
            }, i * 400);
        }
        
        // Continuously create new particles
        setInterval(() => {
            this.createParticle();
        }, 2000);
    }
    
    createParticle() {
        const particle = document.createElement('div');
        particle.className = 'hero-particle';
        particle.style.left = Math.random() * 100 + 'vw';
        particle.style.animationDelay = Math.random() * 8 + 's';
        particle.style.animationDuration = (8 + Math.random() * 4) + 's';
        
        this.particlesContainer.appendChild(particle);
        
        setTimeout(() => {
            particle.remove();
        }, 12000);
    }
    
    startAutoFiring() {
        this.isAutoFiring = true;
        this.autoFireInterval = setInterval(() => {
            if (this.isAutoFiring) {
                this.randomFire();
            }
        }, 3000 + Math.random() * 2000);
    }
    
    stopAutoFiring() {
        this.isAutoFiring = false;
        if (this.autoFireInterval) {
            clearInterval(this.autoFireInterval);
        }
    }
    
    randomFire() {
        const startX = Math.random() * window.innerWidth * 0.2;
        const startY = Math.random() * window.innerHeight;
        const endX = window.innerWidth * 0.8 + Math.random() * window.innerWidth * 0.2;
        const endY = Math.random() * window.innerHeight;
        
        this.createBulletTrail(startX, startY, endX, endY);
    }
    
    createBulletTrail(startX, startY, endX = null, endY = null) {
        // Default target if not specified
        if (endX === null) {
            endX = window.innerWidth * 0.7 + Math.random() * window.innerWidth * 0.3;
            endY = window.innerHeight * 0.3 + Math.random() * window.innerHeight * 0.4;
        }
        
        // Create muzzle flash
        this.createMuzzleFlash(startX, startY);
        
        // Create bullet
        const bullet = document.createElement('div');
        bullet.className = 'bullet';
        bullet.style.left = startX + 'px';
        bullet.style.top = startY + 'px';
        
        // Calculate angle
        const angle = Math.atan2(endY - startY, endX - startX);
        bullet.style.transform = `rotate(${angle}rad)`;
        
        this.bulletContainer.appendChild(bullet);
        
        // Create bullet trail
        const trail = document.createElement('div');
        trail.className = 'bullet-trail';
        trail.style.left = startX + 'px';
        trail.style.top = startY + 'px';
        trail.style.width = '0px';
        trail.style.transform = `rotate(${angle}rad)`;
        trail.style.transformOrigin = 'left center';
        
        this.bulletContainer.appendChild(trail);
        
        // Animate bullet and trail
        const distance = Math.sqrt(Math.pow(endX - startX, 2) + Math.pow(endY - startY, 2));
        const duration = Math.min(distance / 2, 800); // Max 800ms
        
        // Animate bullet
        bullet.animate([
            { left: startX + 'px', top: startY + 'px' },
            { left: endX + 'px', top: endY + 'px' }
        ], {
            duration: duration,
            easing: 'linear'
        });
        
        // Animate trail
        trail.animate([
            { width: '0px' },
            { width: distance + 'px' }
        ], {
            duration: duration * 0.7,
            easing: 'ease-out'
        });
        
        // Create impact effect
        setTimeout(() => {
            this.createImpactEffect(endX, endY);
            bullet.remove();
        }, duration);
        
        // Remove trail
        setTimeout(() => {
            trail.remove();
        }, duration + 500);
        
        // Create shell casing
        this.createShellCasing(startX, startY);
    }
    
    createMuzzleFlash(x, y) {
        const flash = document.createElement('div');
        flash.className = 'muzzle-flash';
        flash.style.left = (x - 10) + 'px';
        flash.style.top = (y - 10) + 'px';
        
        this.bulletContainer.appendChild(flash);
        
        setTimeout(() => {
            flash.remove();
        }, 100);
    }
    
    createImpactEffect(x, y) {
        const impact = document.createElement('div');
        impact.className = 'impact-effect';
        impact.style.left = (x - 8) + 'px';
        impact.style.top = (y - 8) + 'px';
        
        this.bulletContainer.appendChild(impact);
        
        // Create impact sparks
        for (let i = 0; i < 5; i++) {
            const spark = document.createElement('div');
            spark.style.position = 'absolute';
            spark.style.width = '2px';
            spark.style.height = '2px';
            spark.style.background = '#fbbf24';
            spark.style.left = x + 'px';
            spark.style.top = y + 'px';
            spark.style.borderRadius = '50%';
            
            const sparkAngle = (Math.PI * 2 * i) / 5;
            const sparkDistance = 20 + Math.random() * 20;
            
            spark.animate([
                { 
                    transform: 'translate(0, 0) scale(1)',
                    opacity: 1
                },
                { 
                    transform: `translate(${Math.cos(sparkAngle) * sparkDistance}px, ${Math.sin(sparkAngle) * sparkDistance}px) scale(0)`,
                    opacity: 0
                }
            ], {
                duration: 300 + Math.random() * 200,
                easing: 'ease-out'
            });
            
            this.bulletContainer.appendChild(spark);
            
            setTimeout(() => {
                spark.remove();
            }, 500);
        }
        
        setTimeout(() => {
            impact.remove();
        }, 300);
    }
    
    createShellCasing(x, y) {
        const casing = document.createElement('div');
        casing.className = 'shell-casing';
        casing.style.left = x + 'px';
        casing.style.top = y + 'px';
        
        this.bulletContainer.appendChild(casing);
        
        setTimeout(() => {
            casing.remove();
        }, 1000);
    }
    
    triggerBurst() {
        const burstCount = 5 + Math.random() * 5;
        const startX = 50 + Math.random() * 100;
        const startY = window.innerHeight * 0.4 + Math.random() * window.innerHeight * 0.2;
        
        for (let i = 0; i < burstCount; i++) {
            setTimeout(() => {
                const spread = 100;
                const endX = window.innerWidth * 0.7 + (Math.random() - 0.5) * spread;
                const endY = window.innerHeight * 0.5 + (Math.random() - 0.5) * spread;
                
                this.createBulletTrail(startX, startY, endX, endY);
            }, i * 100);
        }
    }
}

// Initialize firing effects system
let firingSystem;

// Global function for fire demo button
function triggerFireEffect() {
    if (firingSystem) {
        firingSystem.triggerBurst();
    }
}

// Add to cart functionality
async function addToCart(productId, quantity = 1) {
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        });

        const data = await response.json();

        if (data.success) {
            // Update cart count
            updateCartCount();
            
            // Show success message
            showNotification('Product added to cart!', 'success');
        } else {
            showNotification(data.message || 'Error adding product to cart', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error adding product to cart', 'error');
    }
}

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
    
    if (type === 'success') {
        notification.classList.add('bg-green-100', 'border', 'border-green-400', 'text-green-700');
    } else {
        notification.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700');
    }
    
    notification.innerHTML = `
        <div class="flex justify-between items-center">
            <span>${message}</span>
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

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Parallax effect for hero section
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelector('.hero-gradient');
    if (parallax) {
        const speed = scrolled * 0.5;
        parallax.style.transform = `translateY(${speed}px)`;
    }
    
    // Disable auto-firing when scrolled away from hero
    if (firingSystem) {
        if (scrolled > window.innerHeight * 0.5) {
            firingSystem.stopAutoFiring();
        } else {
            firingSystem.startAutoFiring();
        }
    }
});

// Initialize effects when page loads
document.addEventListener('DOMContentLoaded', () => {
    firingSystem = new FiringEffectsSystem();
    
    // Add keyboard shortcuts for effects
    document.addEventListener('keydown', (e) => {
        if (e.code === 'Space' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            triggerFireEffect();
        }
    });
});

// Enhanced product card interactions
document.addEventListener('DOMContentLoaded', () => {
    const productCards = document.querySelectorAll('.card-product');
    
    productCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            // Add subtle glow effect
            card.style.boxShadow = '0 20px 40px rgba(0,0,0,0.1), 0 0 20px rgba(102, 126, 234, 0.2)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.boxShadow = '';
        });
    });
});
</script>
@endpush