@extends('noccea.community.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
            <p class="text-gray-600 mt-1">Explore organized topics and discussions</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('noccea.community.categories.show', $category) }}"
                   class="bg-white rounded-lg shadow hover:shadow-md transition p-6 block">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="text-3xl">{{ $category->icon }}</div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->discussions_count }} discussions</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">{{ $category->description }}</p>

                    @if($category->last_activity_at)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500">
                                Last activity {{ $category->last_activity_at->diffForHumans() }}
                            </p>
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
