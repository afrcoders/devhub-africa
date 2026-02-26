@extends('noccea.business.layout')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section with Statistics -->
    <div class="relative bg-gradient-to-r from-purple-600 to-indigo-700 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-800 to-indigo-900 opacity-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Discover Amazing <span class="text-yellow-400">Businesses</span>
                </h1>
                <p class="text-xl md:text-2xl text-purple-100 mb-8 max-w-3xl mx-auto">
                    Connect with innovative businesses, explore products and services, and grow your network across Africa
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="{{ route('noccea.business.businesses.index') }}"
                       class="inline-flex items-center px-8 py-3 bg-yellow-400 text-gray-900 rounded-lg font-semibold hover:bg-yellow-300 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Explore Businesses
                    </a>
                    @auth
                        <a href="{{ route('noccea.business.businesses.create') }}"
                           class="inline-flex items-center px-8 py-3 bg-transparent text-white border-2 border-white rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            List Your Business
                        </a>
                    @else
                        <a href="{{ route('noccea.business.login') }}"
                           class="inline-flex items-center px-8 py-3 bg-transparent text-white border-2 border-white rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Sign In
                        </a>
                    @endauth
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-yellow-400 mb-2">{{ number_format($stats['total_businesses']) }}</div>
                        <div class="text-purple-100">Active Businesses</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-yellow-400 mb-2">{{ number_format($stats['total_categories']) }}</div>
                        <div class="text-purple-100">Categories</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-yellow-400 mb-2">{{ number_format($stats['featured_businesses']) }}</div>
                        <div class="text-purple-100">Featured</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-yellow-400 mb-2">{{ number_format($stats['total_reviews']) }}</div>
                        <div class="text-purple-100">Reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Businesses Section -->
    @if($featuredBusinesses->count() > 0)
        <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Businesses</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover top-rated businesses handpicked by our community</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                    @foreach($featuredBusinesses as $business)
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                            <div class="p-6">
                                <!-- Business Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition-colors">
                                            <a href="{{ route('noccea.business.businesses.show', $business) }}">{{ $business->name }}</a>
                                        </h3>
                                        <p class="text-sm text-purple-600 font-medium">{{ $business->category->name }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Featured
                                    </span>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($business->description, 120) }}</p>

                                <!-- Location and Rating -->
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        {{ $business->city }}
                                    </div>
                                    @if($business->rating > 0)
                                        <div class="flex items-center">
                                            <div class="flex items-center mr-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= $business->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                         fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-gray-600">({{ $business->reviews_count }})</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="{{ route('noccea.business.businesses.featured') }}"
                       class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                        View All Featured Businesses
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Categories Section -->
    @if($topCategories->count() > 0)
        <div class="py-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Browse by Category</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Find businesses in your area of interest</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($topCategories as $category)
                        <a href="{{ route('noccea.business.categories.show', $category) }}"
                           class="group bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg hover:border-purple-300 transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">
                                        {{ $category->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ $category->businesses_count }} {{ Str::plural('business', $category->businesses_count) }}</p>
                                </div>
                                <div class="text-purple-500 group-hover:text-purple-600 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="{{ route('noccea.business.categories.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        View All Categories
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Businesses Section -->
    @if($recentBusinesses->count() > 0)
        <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Recently Added</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Fresh businesses joining our community</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($recentBusinesses as $business)
                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden group">
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">
                                    <a href="{{ route('noccea.business.businesses.show', $business) }}" class="line-clamp-2">
                                        {{ $business->name }}
                                    </a>
                                </h3>
                                <p class="text-xs text-purple-600 font-medium mb-2">{{ $business->category->name }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ $business->city }}</span>
                                    <span>{{ $business->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="{{ route('noccea.business.businesses.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                        Explore All Businesses
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Call to Action for Business Owners -->
    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Grow Your Business?</h2>
            <p class="text-lg text-indigo-100 mb-8 max-w-2xl mx-auto">
                Join thousands of businesses already showcasing their products and services on our platform. Start connecting with customers today.
            </p>
            @auth
                <a href="{{ route('noccea.business.businesses.create') }}"
                   class="inline-flex items-center px-8 py-4 bg-yellow-400 text-gray-900 text-lg font-semibold rounded-lg hover:bg-yellow-300 transition-colors">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    List Your Business Now
                </a>
            @else
                <a href="{{ route('noccea.business.login') }}"
                   class="inline-flex items-center px-8 py-4 bg-yellow-400 text-gray-900 text-lg font-semibold rounded-lg hover:bg-yellow-300 transition-colors">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Get Started Today
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
