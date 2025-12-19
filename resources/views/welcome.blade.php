<x-website-layout>
    <!-- Hero Section -->
    <section id="home" class="relative pt-24 pb-16 md:pt-32 md:pb-24 text-white overflow-hidden">

        <!-- Background image -->
        <img src="{{ asset('backend/business/images/landing-hero-2.jpg') }}"
            alt="Hero Background"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- Dark transparent overlay (controls darkness) -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">New Pak PINDI AUTOS</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    IMPORTERS - WHOLESALERS SPARE PARTS
                </p>

                <!-- Buttons -->
                {{-- <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('our_products') }}"
                        class="px-8 py-3 bg-secondary-600 hover:bg-secondary-700 rounded-md text-white font-medium transition-slow">
                        Our Products
                    </a>
                    <a href="#contact"
                        class="px-8 py-3 border-2 border-white hover:bg-white hover:text-gray-900 rounded-md text-white font-medium transition-slow">
                        Contact Us
                    </a>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Features Section -->
    {{-- <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Quality Assurance</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        We provide only genuine OEM and high-quality aftermarket parts that enhance your vehicle's performance
                    </p>
                </div>

                
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-truck text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">Fast Delivery</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Nationwide express shipping with same-day dispatch on orders placed before 3PM
                    </p>
                </div>

                
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow text-center">
                    <div class="text-primary-600 mb-4 mx-auto w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 dark:text-white">24/7 Support</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Our expert team is available round the clock to answer your queries and provide guidance
                    </p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Categories Section -->
    {{-- <section id="categories" class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3 dark:text-white">Products <span class="text-gradient">Categories</span></h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Browse our premium quality parts organized by category
                </p>
            </div>

            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @forelse($categories as $category)
                <a href="{{ route('all.products', ['category' => $category->id]) }}"
                    class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition duration-300">

                    
                    <div class="w-16 h-16 flex-shrink-0">
                        <img src="{{ $category->image ? asset($category->image) : asset('backend/assets/images/no_image.png') }}"
                            alt="{{ $category->name ?? 'no_img' }}"
                            class="w-full h-full object-cover rounded-lg">
                    </div>

                    
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                            {{ $category->name }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <!-- {{ $category->products_count }} products -->
                        </p>
                    </div>
                </a>
                @empty
                <p class="col-span-full text-center text-gray-500 dark:text-gray-400">No categories available.</p>
                @endforelse
            </div>

        </div>
    </section> --}}

    <!-- Products Section -->
    {{-- <section id="products" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3 dark:text-white">Featured <span class="text-gradient">Products</span></h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Premium quality parts for all major heavy vehicle brands
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($featuredProducts as $product)
                @php
                $variant = $product->default_variant;
                $hasDiscount = $variant && $variant->has_discount;
                $discountPercent = $variant ? $variant->discount_percentage : 0;
                @endphp
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card">
                    <div class="relative product-image-container">
                        @if($product->image_paths)
                        @php
                        $images = json_decode($product->image_paths);
                        $firstImage = $images[0] ?? null;
                        @endphp
                        <img src="{{ asset('backend/'.$firstImage) }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                        @else
                        <img src="{{ asset('/backend/assets/images/no_image.png') }}"
                            alt="no_image.png" class="w-full h-48 object-cover">
                        @endif
                        <div class="product-overlay">
                            <button class="action-btn heart-btn" title="Add to wishlist">
                                <i class="fas fa-heart"></i>
                            </button>
                            <button class="action-btn view-btn" title="View details" onclick="window.location.href='{{ route('product.detail', ['id' => $product->id, 'slug' => Str::slug($product->name)]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn cart-btn" title="Add to cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                        @if($hasDiscount)
                        <div class="discount-badge">{{ $discountPercent }}% OFF</div>
                        @endif
                        <div class="availability-badge {{ $product->is_in_stock ? 'available' : 'not-available' }}">
                            {{ $product->is_in_stock ? 'In Stock' : 'Out of Stock' }}
                        </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 dark:text-white">{{ $product->name }}</h3>
                    <div class="flex justify-between items-center mt-4">
                        @if($variant)
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                            Rs {{ number_format($variant->selling_price, 2) }}
                        </span>
                        @endif
                        <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow text-sm"
                            onclick="window.location.href='{{ route('product.detail', ['id' => $product->id, 'slug' => Str::slug($product->name)]) }}'">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            @empty
            
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card">
                <div class="relative product-image-container">
                    <img src="{{ asset('backend/assets/images/Engine_Components.jpg') }}"
                        alt="Engine Parts" class="w-full h-48 object-cover">
                    <div class="product-overlay">
                        <button class="action-btn heart-btn" title="Add to wishlist">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="action-btn view-btn" title="View details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn cart-btn" title="Add to cart">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                    <div class="discount-badge">10% OFF</div>
                    <div class="availability-badge available">In Stock</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 dark:text-white">Engine Components</h3>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">$149.99</span>
                        <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow text-sm">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card">
                <div class="relative product-image-container">
                    <img src="{{ asset('backend/assets/images/brake_system.jpg') }}"
                        alt="Brake System" class="w-full h-48 object-cover">
                    <div class="product-overlay">
                        <button class="action-btn heart-btn" title="Add to wishlist">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="action-btn view-btn" title="View details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn cart-btn" title="Add to cart">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                    <div class="availability-badge available">In Stock</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 dark:text-white">Brake System</h3>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">$79.99</span>
                        <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow text-sm">
                            View Details
                        </button>
                    </div>
                </div>
            </div>

            
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-slow product-card">
                <div class="relative product-image-container">
                    <img src="{{ asset('backend/assets/images/Suspension_Parts.jpg') }}"
                        alt="Suspension Parts" class="w-full h-48 object-cover">
                    <div class="product-overlay">
                        <button class="action-btn heart-btn" title="Add to wishlist">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="action-btn view-btn" title="View details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn cart-btn" title="Add to cart">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                    <div class="discount-badge">20% OFF</div>
                    <div class="availability-badge available">In Stock</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 dark:text-white">Suspension Parts</h3>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">$219.99</span>
                        <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-slow text-sm">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            @endforelse

        </div>
        <div class="text-center mt-12">
            <a href="{{ route('all.products') }}" class="inline-flex items-center px-8 py-3 border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white rounded-md font-medium transition-slow dark:border-primary-500 dark:text-primary-500 dark:hover:bg-primary-500 dark:hover:text-white">
                View All Products <i class="fas fa-chevron-right ml-2"></i>
            </a>
        </div>
        </div>
    </section> --}}

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Contact <span class="text-gradient">Us</span></h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Get in touch with our team for inquiries or support
                </p>
            </div>

            <div class="">
                {{-- <div class="flex flex-col md:flex-row gap-12"> --}}
                <!-- Contact Info -->
                <div class="bg-gray-900 text-white p-8 rounded-xl">
                {{-- <div class="md:w-1/2 bg-gray-900 text-white p-8 rounded-xl"> --}}
                    <h3 class="text-2xl font-bold mb-6">Contact Information</h3>
                    <p class="mb-8 opacity-90">
                        Use the information below to reach us or fill out the form.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">Address</h4>
                                <p class="opacity-90">
                                    LS-34 , Super Auto Market<br>
                                    Sohrab Goth Karachi Pakistan<br>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">Phone</h4>
                                <div class="space-y-2 opacity-90">
                                    <div>
                                        <span class="font-semibold">Prop : Habib Ur Rehman,</span><br>
                                        <a href="tel:+923332460463" class="hover:text-primary-300 transition-colors">0318-1068585</a>
                                        <a href="tel:+923332460463" class="hover:text-primary-300 transition-colors">0344-2070722</a>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Manager : Saif Ur Rehman,</span><br>
                                        <a href="tel:+923070005315" class="hover:text-primary-300 transition-colors">0315-1026553</a><br>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">Email</h4>
                                <p class="opacity-90">
                                    <a href="mailto:pakpindiautos2020@gmail.com" class="hover:text-primary-300 transition-colors">
                                        pakpindiautos2020@gmail.com
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-4 opacity-80"></i>
                            <div>
                                <h4 class="font-bold mb-1">Business Hours</h4>
                                <p class="opacity-90">Monday - Saturday: 9AM to 6PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                {{-- <div class="md:w-1/2">
                    <div class="bg-white p-8 rounded-xl shadow-md">
                        <h3 class="text-2xl font-bold mb-6">Send Us a Message</h3>
                        <form id="contactForm">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Name</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                    bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                    focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    placeholder="Your name" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email</label>
                                <input type="email" id="email" name="email"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                    bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                    focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    placeholder="Your email" required>
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Phone</label>
                                <input type="tel" id="phone" name="phone"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                    bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                    focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    placeholder="Your phone number">
                            </div>
                            <div class="mb-6">
                                <label for="message" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Message</label>
                                <textarea id="message" name="message" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                    bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 
                    focus:outline-none focus:ring-2 focus:ring-primary-500"
                                    placeholder="Your message" required></textarea>
                            </div>
                            <button type="submit" id="submitBtn" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-md transition-slow">
                                Send Message <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    {{-- <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3 dark:text-white">Customer <span class="text-gradient">Testimonials</span></h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    What our valued customers say about us
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @if(empty($testimonials))
                @foreach($testimonials as $testimonial)
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-half-alt' }}"></i>
                            @endfor
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic">
                        "{{ $testimonial->testimonial }}"
                    </p>
                    <div class="flex items-center">
                        <img src="{{ $testimonial->avatar_url }}"
                            alt="{{ $testimonial->customer_name }}" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-4">
                            <h4 class="font-bold dark:text-white">{{ $testimonial->customer_name }}</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $testimonial->customer_position }}</p>
                            @if($testimonial->company)
                            <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $testimonial->company }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <!-- Testimonial 1 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        "I've been purchasing parts from Saif Pindi Autos for years. Their quality and service are unmatched in the industry."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold dark:text-white">Ali Khan</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Transport Company Owner</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        "Their parts last longer than competitors' and the prices are reasonable. Delivery is always on time."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold dark:text-white">Ahmed Raza</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Fleet Maintenance Manager</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-slow">
                    <div class="text-yellow-400 mb-4">
                        <i class="fas fa-quote-left text-2xl opacity-50"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        "Whenever I need parts for my trucks, Saif Pindi Autos is my first choice. Their technical support is excellent."
                    </p>
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h4 class="font-bold dark:text-white">Usman Malik</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Logistics Operator</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section> --}}


    @push('js')


    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');

            contactForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Change button text to show loading
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = 'Sending... <i class="fas fa-spinner fa-spin ml-2"></i>';
                submitBtn.disabled = true;

                try {
                    const formData = new FormData(contactForm);

                    const response = await fetch('{{ route("contact.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });

                        // Reset form
                        contactForm.reset();
                    } else {
                        throw new Error(data.message || 'Something went wrong');
                    }

                } catch (error) {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'Failed to send message. Please try again.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Try Again'
                    });
                } finally {
                    // Restore button text
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            });
        });
    </script>
    @endpush
</x-website-layout>