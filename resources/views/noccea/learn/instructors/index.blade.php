@extends('noccea.learn.layout')

@section('title', 'Instructors')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Expert Instructors</h1>
            <p class="text-xl text-gray-600">Learn from industry professionals and thought leaders</p>
        </div>

        <!-- Instructors Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @forelse($instructors as $instructor)
            <div class="text-center">
                <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($instructor->name, 0, 2)) }}
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $instructor->name }}</h3>
                <p class="text-gray-600 text-sm mb-1">@{{ $instructor->username }}</p>
                <p class="text-gray-600 text-sm mb-3">{{ $instructor->specialty }}</p>
                <div class="flex items-center justify-center space-x-1 mb-4">
                    @for($j = 0; $j < 5; $j++)
                    <svg class="w-4 h-4 {{ $j < $instructor->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                    <span class="text-xs text-gray-500">{{ $instructor->rating }}/5</span>
                </div>
                <button class="px-4 py-2 border border-orange-600 text-orange-600 rounded-lg hover:bg-orange-50">View Profile</button>
            </div>
            @empty
            <div class="col-span-4 text-center py-12">
                <p class="text-gray-500">No instructors available yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
