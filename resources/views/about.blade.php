<x-website-layout>
    @push('css')
        <style>
            :root {
                --primary: #2563eb;
                --secondary: #ea580c;
                --dark: #1e293b;
                --light: #f8fafc;
            }
            
            .text-gradient {
                background: linear-gradient(90deg, var(--primary), var(--secondary));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .stat-card {
                position: relative;
                overflow: hidden;
            }
            
            .stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 5px;
                height: 0;
                background: var(--secondary);
                transition: height 0.5s ease;
            }
            
            .stat-card:hover::before {
                height: 100%;
            }
            
        </style>
    @endpush
    <!-- Hero Section -->
    <section id="home" class="relative pt-24 pb-16 md:pt-32 md:pb-24 text-white overflow-hidden">

        <!-- Background image -->
        <img src="{{ asset('backend/business/images/landing-hero-3.jpg') }}" 
            alt="Hero Background" 
            class="absolute inset-0 w-full h-full object-cover">

        <!-- Dark transparent overlay (controls darkness) -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">MD AUTOS</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Your trusted supplier of genuine heavy vehicle parts and components
                </p>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('our_products') }}" 
                    class="px-8 py-3 bg-secondary-600 hover:bg-secondary-700 rounded-md text-white font-medium transition-slow">
                        Our Products
                    </a>
                    <a href="#contact" 
                    class="px-8 py-3 border-2 border-white hover:bg-white hover:text-gray-900 rounded-md text-white font-medium transition-slow">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2">
                    <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}"
                        alt="About MD Autos" class="rounded-xl shadow-md w-full">
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-6">About <span class="text-gradient">MD Autos</span></h2>
                    <p class="text-gray-600 mb-4">
                        MD Autos is a leading supplier of heavy vehicle parts with decades of experience in the automotive industry. Our mission is to provide our customers with the highest quality parts at competitive prices.
                    </p>
                    <p class="text-gray-600 mb-6">
                        Our team of experienced professionals will help you find the right parts for your specific needs. We source parts only from authorized and trusted manufacturers to ensure you receive the best products available.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600">Genuine OEM and premium aftermarket parts</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600">Competitive pricing with volume discounts</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600">Fast nationwide delivery</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-600">Expert technical advice and support</span>
                        </li>
                    </ul>
                    <div class="mt-8">
                        <a href="#contact" class="inline-flex items-center px-6 py-3 bg-primary hover:bg-blue-700 text-white rounded-md font-medium transition">
                            Get in Touch <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Stats Section -->
    <section class="py-16 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div class="p-6 stat-card bg-blue-700 rounded-lg">
                    <div class="text-4xl font-bold mb-2">20+</div>
                    <div class="text-lg">Years in Business</div>
                </div>
                <div class="p-6 stat-card bg-blue-700 rounded-lg">
                    <div class="text-4xl font-bold mb-2">5000+</div>
                    <div class="text-lg">Happy Customers</div>
                </div>
                <div class="p-6 stat-card bg-blue-700 rounded-lg">
                    <div class="text-4xl font-bold mb-2">10K+</div>
                    <div class="text-lg">Parts in Stock</div>
                </div>
                <div class="p-6 stat-card bg-blue-700 rounded-lg">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-lg">Customer Support</div>
                </div>
            </div>
        </div>
    </section>

</x-website-layout>