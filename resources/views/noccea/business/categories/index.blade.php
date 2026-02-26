@extends('noccea.business.layout')

@section('title', 'Business Categories')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Business Categories</h1>
            <p class="text-gray-600 mt-2">Explore businesses by category</p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($categories as $category)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                    <a href="{{ route('noccea.business.categories.show', $category) }}" class="block p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-500">{{ $category->businesses_count }} businesses</span>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $category->description ?: 'Discover businesses in this category' }}</p>

                        <div class="mt-4 flex items-center text-purple-600 text-sm font-medium">
                            Browse Category
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No categories available</h3>
                    <p class="mt-2 text-gray-500">Categories will appear here once they're created.</p>
                </div>
            @endforelse
        </div>

        <!-- Quick Stats -->
        <div class="mt-12 bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div>
                    <div class="text-3xl font-bold text-purple-600">{{ $categories->count() }}</div>
                    <div class="text-gray-600">Categories</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-purple-600">{{ $totalBusinesses }}</div>
                    <div class="text-gray-600">Total Businesses</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-purple-600">{{ $activeBusinesses }}</div>
                    <div class="text-gray-600">Active Listings</div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-8 bg-purple-50 rounded-lg p-8 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-3">Can't find your category?</h3>
            <p class="text-gray-600 mb-6">We're always expanding our categories. Contact us to suggest a new one!</p>

            @auth
                <a href="{{ route('noccea.business.businesses.create') }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium mr-4">
                    List Your Business
                </a>
            @else
                <a href="{{ route('noccea.business.login') }}"
                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium mr-4">
                   Get Started
                </a>
            @endauth

            <a href="{{ route('noccea.business.businesses.index') }}"
               class="border border-purple-600 text-purple-600 hover:bg-purple-600 hover:text-white px-6 py-3 rounded-lg font-medium">
                Browse All Businesses
            </a>
        </div>
    </div>
</div>
@endsection
