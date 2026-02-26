<?php

namespace App\Http\Controllers\Noccea\Community;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('is_active', true)
            ->withCount(['discussions', 'discussionReplies']);

        // Search members
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('username', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Sort
        switch ($request->sort) {
            case 'discussions':
                $query->orderBy('discussions_count', 'desc');
                break;
            case 'replies':
                $query->orderBy('discussion_replies_count', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('last_login', 'desc')
                    ->orderBy('created_at', 'desc');
                break;
        }

        $members = $query->paginate(24);

        return view('noccea.community.members.index', compact('members'));
    }

    public function show(User $user)
    {
        $user->loadCount(['discussions', 'discussionReplies']);

        $recentDiscussions = $user->discussions()
            ->with('category')
            ->withCount('replies')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentReplies = $user->discussionReplies()
            ->with(['discussion.category', 'discussion.user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('noccea.community.members.show', compact('user', 'recentDiscussions', 'recentReplies'));
    }

    public function topContributors(Request $request)
    {
        $period = $request->get('period', 'all'); // all, month, week

        $query = User::where('is_active', true)
            ->withCount(['discussions', 'discussionReplies']);

        // Filter by time period for activity
        if ($period !== 'all') {
            $date = match($period) {
                'week' => now()->subWeek(),
                'month' => now()->subMonth(),
                default => now()->subYear()
            };

            $query->where(function ($q) use ($date) {
                $q->whereHas('discussions', function ($discussionQuery) use ($date) {
                    $discussionQuery->where('created_at', '>=', $date);
                })->orWhereHas('discussionReplies', function ($replyQuery) use ($date) {
                    $replyQuery->where('created_at', '>=', $date);
                });
            });
        }

        // Calculate total contributions (discussions + replies) and sort
        $topContributors = $query->get()
            ->map(function ($user) {
                $user->total_contributions = $user->discussions_count + $user->discussion_replies_count;
                return $user;
            })
            ->sortByDesc('total_contributions')
            ->take(50);

        return view('noccea.community.members.top-contributors', compact('topContributors', 'period'));
    }
}
