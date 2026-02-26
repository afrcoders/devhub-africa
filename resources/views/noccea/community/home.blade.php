@extends('noccea.community.layout')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section with Stats -->
    <div class="bg-gradient-to-r from-green-600 via-green-700 to-emerald-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12">
                <div class="flex justify-center mb-6">
                    <img src="/noccea/logo-white.svg" alt="Noccea Community" class="h-16">
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Welcome to Our Community
                </h1>
                <p class="text-xl text-green-100 max-w-3xl mx-auto">
                    Join thousands of innovators, creators, and entrepreneurs sharing knowledge, building connections, and growing together.
                </p>
            </div>

            <!-- Community Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold">{{ number_format($stats['total_members']) }}</div>
                    <div class="text-green-200">Members</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold">{{ number_format($stats['total_discussions']) }}</div>
                    <div class="text-green-200">Discussions</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold">{{ number_format($stats['total_replies']) }}</div>
                    <div class="text-green-200">Replies</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold">{{ number_format($stats['active_today']) }}</div>
                    <div class="text-green-200">Active Today</div>
                </div>
            </div>

            @auth
                <div class="text-center mt-8">
                    <a href="{{ route('noccea.community.discussions.create') }}" class="inline-flex items-center px-8 py-3 bg-white text-green-700 rounded-lg font-semibold hover:bg-green-50 transition shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Start a Discussion
                    </a>
                </div>
            @else
                <div class="text-center mt-8">
                    <a href="{{ route('noccea.community.login') }}" class="inline-flex items-center px-8 py-3 bg-white text-green-700 rounded-lg font-semibold hover:bg-green-50 transition shadow-lg mr-4">
                        Sign In to Join
                    </a>
                    <a href="#explore" class="inline-flex items-center px-8 py-3 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-green-700 transition">
                        Explore Community
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Left Column - Recent Activity -->
            <div class="lg:col-span-2">

                <!-- Recent Discussions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Recent Discussions
                        </h2>
                        <a href="{{ route('noccea.community.discussions.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">View all →</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($recentDiscussions as $discussion)
                            <div class="px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-start space-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($discussion->user->name) }}&size=40&background=10b981&color=fff"
                                         alt="{{ $discussion->user->name }}" class="w-10 h-10 rounded-full">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                                {{ $discussion->category->name }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $discussion->created_at->diffForHumans() }}</span>
                                        </div>
                                        <h3 class="text-sm font-medium text-gray-900 hover:text-green-600">
                                            <a href="{{ route('noccea.community.discussions.show', $discussion) }}" class="hover:underline">
                                                {{ $discussion->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit(strip_tags($discussion->body), 120) }}</p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="text-xs text-gray-500">by {{ $discussion->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $discussion->replies_count }} replies</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p>No recent discussions. Be the first to start one!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Popular Discussions -->
                @if($popularDiscussions->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                            </svg>
                            Trending This Month
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($popularDiscussions as $discussion)
                            <div class="px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-sm font-medium text-gray-900 hover:text-green-600">
                                            <a href="{{ route('noccea.community.discussions.show', $discussion) }}" class="hover:underline">
                                                {{ $discussion->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center space-x-3 mt-1">
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">
                                                {{ $discussion->category->name }}
                                            </span>
                                            <span class="text-xs text-gray-500">by {{ $discussion->user->name }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center text-orange-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">{{ $discussion->replies_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">

                <!-- Quick Navigation -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Quick Access</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <a href="{{ route('noccea.community.discussions.index') }}" class="flex items-center p-3 rounded-lg hover:bg-green-50 group transition">
                                <div class="w-10 h-10 bg-green-100 group-hover:bg-green-200 rounded-lg flex items-center justify-center transition">
                                    <span class="text-xl">💬</span>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Discussions</div>
                                    <div class="text-xs text-gray-500">{{ number_format($stats['total_discussions']) }} topics</div>
                                </div>
                            </a>

                            <a href="{{ route('noccea.community.categories.index') }}" class="flex items-center p-3 rounded-lg hover:bg-blue-50 group transition">
                                <div class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center transition">
                                    <span class="text-xl">📁</span>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Categories</div>
                                    <div class="text-xs text-gray-500">{{ $activeCategories->count() }} active</div>
                                </div>
                            </a>

                            <a href="{{ route('noccea.community.members.index') }}" class="flex items-center p-3 rounded-lg hover:bg-purple-50 group transition">
                                <div class="w-10 h-10 bg-purple-100 group-hover:bg-purple-200 rounded-lg flex items-center justify-center transition">
                                    <span class="text-xl">👥</span>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">Members</div>
                                    <div class="text-xs text-gray-500">{{ number_format($stats['total_members']) }} joined</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Active Categories -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Popular Categories</h3>
                        <a href="{{ route('noccea.community.categories.index') }}" class="text-green-600 hover:text-green-700 text-sm">View all →</a>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            @forelse($activeCategories->take(6) as $category)
                                <a href="{{ route('noccea.community.categories.show', $category) }}" class="block p-3 rounded-lg hover:bg-gray-50 transition">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <span class="text-sm">{{ substr($category->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $category->discussions_count }} discussions</div>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $category->replies_count ?? 0 }} replies
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">No active categories</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Active Members -->
                @if($activeMembers->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Active Members</h3>
                        <a href="{{ route('noccea.community.members.index') }}" class="text-green-600 hover:text-green-700 text-sm">View all →</a>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            @foreach($activeMembers as $member)
                                <div class="flex items-center space-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->username) }}&size=32&background=10b981&color=fff"
                                         alt="{{ $member->username }}" class="w-8 h-8 rounded-full">
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900 truncate">{{ $member->username }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $member->discussions_count }} discussions, {{ $member->discussion_replies_count }} replies
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Features Section for Guests -->
    @guest
    <div id="explore" class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Join Our Community?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Connect, learn, and grow with like-minded individuals</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2l-4 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Rich Discussions</h3>
                    <p class="text-gray-600">Engage in meaningful conversations on topics that matter to you and the community.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Network & Learn</h3>
                    <p class="text-gray-600">Connect with professionals, entrepreneurs, and innovators from around the world.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Growth & Impact</h3>
                    <p class="text-gray-600">Share your knowledge, learn from others, and make a positive impact in our community.</p>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('noccea.community.login') }}" class="inline-flex items-center px-8 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition shadow-lg">
                    Join the Community Today
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @endguest
</div>
@endsection
