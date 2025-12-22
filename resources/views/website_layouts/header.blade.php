    <nav class="fixed w-full bg-white dark:bg-gray-900 shadow-md z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('home.index', [], false)) }}">
                    <div class="flex-shrink-0 flex items-center">
                        {{-- <img class="h-6 w-auto" src="{{ asset('backend/assets/images/MDLogo.jpg') }}" alt="MD Autos Logo">&nbsp;&nbsp;  --}}
                        <span class="text-2xl font-semibold text-sky-500"> PAK PINDI</span>
                    </div>
                </a>

                <!-- Nav items -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('home.index', [], false)) }}" class="px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                        {{ __('messages.home') }}
                    </a>
                    {{-- <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('all.products', [], false)) }}" class="px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                        {{ __('messages.products') }}
                    </a>
                    <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('about.us', [], false)) }}" class="px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                        {{ __('messages.about') }}
                    </a>
                    <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('home.index', [], false)) }}/#contact" class="px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                        {{ __('messages.contact') }}
                    </a> --}}
                    
                    <!-- Language Switcher -->
                    {{-- <div class="relative" x-data="{ open: false }">
                        @php
                            $languages = config('languages');
                        @endphp
                        <button @click="open = !open" class="px-4 py-2 rounded-md text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300 flex items-center">
                            <span class="fi fi-{{ $languages[app()->getLocale()]['flag'] }} mr-2"></span>

                            comment this
                            {{ -- {{ LaravelLocalization::getCurrentLocaleNative() }} -- }}
                            <i class="fas fa-chevron-down ml-1 text-xs" :class="{'transform rotate-180': open}"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50" style="display: none;">
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                @if ($localeCode != app()->getLocale())
                                    <a href="{{ route('lang.switch', $localeCode) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                        <span class="fi fi-{{ $languages[$localeCode]['flag'] }} mr-2"></span>
                                        {{ $properties['native'] }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div> --}}
                    
                     @auth
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary-600 hover:bg-primary-700 transition-colors duration-300">
                            {{ __('Dashboard') }}
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="ml-4 px-4 py-2 rounded-md bg-secondary-600 text-white font-medium hover:bg-secondary-700 transition-colors duration-300">
                            {{ __('Login') }}
                        </a>
                    @endguest
                    
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center space-x-4">
                    <!-- Language switcher for mobile -->
                    {{-- <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 rounded-md text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                            <i class="fas fa-globe text-xl"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-md shadow-lg py-2 z-50" style="display: none;">
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a href="{{ route('lang.switch', $localeCode) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center">
                                    <span class="fi fi-{{ $languages[$localeCode]['flag'] }} mr-2"></span>
                                    {{ $properties['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </div> --}}
                    
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition-colors duration-300" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white dark:bg-gray-900 shadow-lg transition-colors duration-300">
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('home.index', [], false)) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                    {{ __('messages.home') }}
                </a>
                {{-- <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('all.products', [], false)) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                    {{ __('messages.products') }}
                </a>
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('about.us', [], false)) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                    {{ __('messages.about') }}
                </a>
                <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), route('home.index', [], false)) }}/#contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300">
                    {{ __('messages.contact') }}
                </a>
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-secondary-600 hover:bg-secondary-700 transition-colors duration-300">
                    {{ __('messages.login') }}
                </a> --}}
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-primary-600 hover:bg-primary-700 transition-colors duration-300">
                        {{ __('Dashboard') }}
                    </a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-secondary-600 hover:bg-secondary-700 transition-colors duration-300">
                        {{ __('Login') }}
                    </a> 
                @endguest
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function(event) {
                    if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>