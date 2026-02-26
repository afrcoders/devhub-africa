@extends('noccea.community.layout')

@section('title', 'Top Contributors')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">🏆 Top Contributors</h1>
        <p class="text-gray-600">Celebrating our most active community members</p>
    </div>

    <!-- Period Filter -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('noccea.community.members.top-contributors', ['period' => 'all']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === 'all' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Time
                </a>
                <a href="{{ route('noccea.community.members.top-contributors', ['period' => 'month']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === 'month' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    This Month
                </a>
                <a href="{{ route('noccea.community.members.top-contributors', ['period' => 'week']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium {{ $period === 'week' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    This Week
                </a>
            </div>
        </div>
    </div>

    <!-- Top Contributors List -->
    <div class="bg-white rounded-lg shadow">
        @if($topContributors->count() > 0)
            @foreach($topContributors as $index => $contributor)
                <div class="flex items-center justify-between p-6 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                    <div class="flex items-center space-x-4">
                        <!-- Rank -->
                        <div class="flex-shrink-0">
                            @if($index === 0)
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 text-yellow-800 font-bold text-lg">
                                    🥇
                                </span>
                            @elseif($index === 1)
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-800 font-bold text-lg">
                                    🥈
                                </span>
                            @elseif($index === 2)
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-orange-100 text-orange-800 font-bold text-lg">
                                    🥉
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-600 font-bold">
                                    {{ $index + 1 }}
                                </span>
                            @endif
                        </div>

                        <!-- Avatar placeholder -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($contributor->name ?? $contributor->username ?? $contributor->full_name ?? 'U', 0, 1)) }}
                            </div>
                        </div>

                        <!-- User Info -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">
                                <a href="{{ route('noccea.community.members.show', $contributor) }}"
                                   class="hover:text-green-600 transition-colors">
                                    {{ $contributor->name ?? $contributor->username ?? $contributor->full_name ?? 'Member' }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600">
                                @if($contributor->bio)
                                    {{ Str::limit($contributor->bio, 60) }}
                                @else
                                    Community Member
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900">
                            {{ number_format($contributor->total_contributions) }}
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Total Contributions</p>

                        <div class="flex space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>
                                {{ $contributor->discussions_count }} discussions
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $contributor->discussion_replies_count }} replies
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="p-12 text-center">
                <div class="mb-4">
                    <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No contributors found</h3>
                <p class="text-gray-600">No active contributors found for this time period.</p>
            </div>
        @endif
    </div>

    <!-- Call to Action -->
    <div class="mt-8 bg-green-50 rounded-lg p-6 text-center">
        <h3 class="text-lg font-semibold text-green-900 mb-2">Want to be featured here?</h3>
        <p class="text-green-700 mb-4">Start contributing to the community by sharing knowledge, asking questions, and helping others!</p>
        <div class="space-x-4">
            <a href="{{ route('noccea.community.discussions.create') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                Start a Discussion
            </a>
            <a href="{{ route('noccea.community.discussions.index') }}"
               class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-green-600 font-medium rounded-lg border border-green-300 transition-colors">
                Browse Discussions
            </a>
        </div>
    </div>
</div>
@endsection
