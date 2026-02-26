@extends('noccea.business.layout')

@section('title', 'Featured Businesses')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Featured Businesses</h1>
            <p class="text-gray-600 mt-2">Discover our highlighted business partners</p>
        </div>

        <!-- Featured Badge Info -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Featured Businesses</h3>
                    <div class="mt-1 text-sm text-yellow-700">
                        <p>These businesses have been selected for their exceptional quality, service, and community contribution.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Businesses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($businesses as $business)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow relative">
                    <!-- Featured Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Featured
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $business->category->name }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            <a href="{{ route('noccea.business.businesses.show', $business) }}" class="hover:text-purple-600">
                                {{ $business->name }}
                            </a>
                        </h3>

                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">{{ Str::limit($business->description, 150) }}</p>

                        <!-- Rating -->
                        <div class="flex items-center mb-4">
                            @if($business->rating > 0)
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $business->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                    <span class="text-sm font-medium text-gray-900 ml-1">{{ $business->rating }}</span>
                                    <span class="text-sm text-gray-500 ml-1">({{ $business->reviews_count }})</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-500">No ratings yet</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $business->city }}, {{ $business->country }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ number_format($business->views_count) }}
                            </div>
                        </div>

                        <!-- Quick Contact -->
                        <div class="flex items-center space-x-3">
                            @if($business->website)
                                <a href="{{ $business->website }}" target="_blank"
                                   class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                                    Website →
                                </a>
                            @endif

                            <a href="{{ route('noccea.business.businesses.show', $business) }}"
                               class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No featured businesses yet</h3>
                    <p class="mt-2 text-gray-500">Check back soon for our featured business listings.</p>
                    <div class="mt-6">
                        <a href="{{ route('noccea.business.businesses.index') }}"
                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium">
                            Browse All Businesses
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($businesses->hasPages())
            <div class="mt-8">
                {{ $businesses->links() }}
            </div>
        @endif

        <!-- Call to Action -->
        <div class="mt-12 bg-white rounded-lg shadow p-8 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-3">Want to be featured?</h3>
            <p class="text-gray-600 mb-6">Join our directory and showcase your business to our growing community.</p>

            @auth
                <a href="{{ route('noccea.business.businesses.create') }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium">
                    Add Your Business
                </a>
            @else
                <a href="{{ route('noccea.business.login') }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium">
                    Get Started
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
