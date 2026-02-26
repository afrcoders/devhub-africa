@extends('noccea.learn.layout')

@section('title', 'Top Learners')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Top Learners</h1>
            <p class="text-xl text-gray-600">Celebrate the most engaged and accomplished learners</p>
        </div>

        <!-- Time Period Filter -->
        <div class="mb-8 flex gap-4">
            <button class="px-4 py-2 bg-orange-600 text-white rounded-lg text-sm font-medium">This Month</button>
            <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">This Year</button>
            <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-medium">All Time</button>
        </div>

        <!-- Leaderboard Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-bold text-gray-900">Rank</th>
                        <th class="text-left py-3 px-4 font-bold text-gray-900">Learner</th>
                        <th class="text-left py-3 px-4 font-bold text-gray-900">Points</th>
                        <th class="text-left py-3 px-4 font-bold text-gray-900">Courses</th>
                        <th class="text-left py-3 px-4 font-bold text-gray-900">Certificates</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topLearners as $learner)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                @if($learner->rank <= 3)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" style="color: {{ ['#FCD34D', '#D1D5DB', '#CD7F32'][$learner->rank-1] }}"/>
                                </svg>
                                @endif
                                <span class="font-bold text-gray-900">#{{ $learner->rank }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($learner->username ?? $learner->name, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="font-medium text-gray-900">{{ $learner->name ?? $learner->username }}</span>
                                    <span class="text-xs text-gray-500 block">@{{ $learner->username }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="font-bold text-gray-900">{{ $learner->points }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-gray-600">{{ $learner->courses }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-gray-600">{{ $learner->certificates }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500">No learners yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
