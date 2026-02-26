<?php

namespace App\Http\Controllers\Noccea\Community;

use App\Http\Controllers\Controller;
use App\Models\Community\Discussion;
use App\Models\Community\DiscussionCategory;
use App\Models\Community\DiscussionReply;
use App\Models\Community\DiscussionVote;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscussionController extends Controller
{
    public function index(Request $request)
    {
        $query = Discussion::with('user', 'category')
            ->withCount('replies');

        // Filter by category
        if ($request->category) {
            $category = DiscussionCategory::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        // Search
        if ($request->search) {
            $query->whereRaw(
                "MATCH(title, body) AGAINST(? IN BOOLEAN MODE)",
                [$request->search]
            );
        }

        // Sort
        switch ($request->sort) {
            case 'popular':
                $query->popular();
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            default:
                $query->pinned()->recent();
                $query->orderBy('is_pinned', 'desc');
                break;
        }

        $discussions = $query->paginate(20);
        $categories = DiscussionCategory::ordered()->get();

        return view('noccea.community.discussions.index', compact('discussions', 'categories'));
    }

    public function show(Discussion $discussion)
    {
        $discussion->load([
            'user',
            'category',
            'replies' => function ($query) {
                $query->with('user', 'children.user')
                    ->whereNull('parent_id')
                    ->orderBy('is_best_answer', 'desc')
                    ->orderBy('created_at');
            },
            'bestReply.user'
        ]);

        // Increment view count
        $discussion->incrementViews();

        // Check if current discussion is bookmarked by the user
        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = auth()->user()->bookmarkedDiscussions()
                ->where('discussion_id', $discussion->id)
                ->exists();
        }

        return view('noccea.community.discussions.show', compact('discussion', 'isBookmarked'));
    }

    public function create()
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => request()->fullUrl()
            ]);
        }

        $categories = DiscussionCategory::ordered()->get();
        return view('noccea.community.discussions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.create')
            ]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:discussion_categories,id'
        ]);

        $discussion = Discussion::create([
            ...$validated,
            'user_id' => auth()->id(),
            'uuid' => Str::uuid(),
            'slug' => Str::slug($validated['title']),
            'last_activity_at' => now()
        ]);

        // Update category counts
        $discussion->category()->increment('discussions_count');
        $discussion->category()->update(['last_activity_at' => now()]);

        $routeName = request()->route()->getName();
        $isSubdomain = str_contains($routeName, 'noccea.community.');

        if ($isSubdomain) {
            return redirect()->route('noccea.community.discussions.show', $discussion)
                ->with('success', 'Discussion created successfully!');
        }

        return redirect()->route('noccea.community.discussions.show', $discussion)
            ->with('success', 'Discussion created successfully!');
    }

    public function edit(Discussion $discussion)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => request()->fullUrl()
            ]);
        }

        $this->authorize('update', $discussion);
        $categories = DiscussionCategory::ordered()->get();
        return view('noccea.community.discussions.edit', compact('discussion', 'categories'));
    }

    public function update(Request $request, Discussion $discussion)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.edit', $discussion)
            ]);
        }

        $this->authorize('update', $discussion);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'required|exists:discussion_categories,id'
        ]);

        $discussion->update([
            ...$validated,
            'slug' => Str::slug($validated['title'])
        ]);

        $routeName = request()->route()->getName();
        $isSubdomain = str_contains($routeName, 'noccea.community.');

        if ($isSubdomain) {
            return redirect()->route('noccea.community.discussions.show', $discussion)
                ->with('success', 'Discussion updated successfully!');
        }

        return redirect()->route('noccea.community.discussions.show', $discussion)
            ->with('success', 'Discussion updated successfully!');
    }

    public function destroy(Discussion $discussion)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.index')
            ]);
        }

        $this->authorize('delete', $discussion);

        $discussion->delete();

        // Check if it's an AJAX request
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Discussion deleted successfully!',
                'redirect' => route('noccea.community.discussions.index')
            ]);
        }

        $routeName = request()->route()->getName();
        $isSubdomain = str_contains($routeName, 'noccea.community.');

        if ($isSubdomain) {
            return redirect()->route('noccea.community.discussions.index')
                ->with('success', 'Discussion deleted successfully!');
        }

        return redirect()->route('noccea.community.discussions.index')
            ->with('success', 'Discussion deleted successfully!');
    }

    public function storeReply(Request $request, Discussion $discussion)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.show', $discussion)
            ]);
        }

        $validated = $request->validate([
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:discussion_replies,id'
        ]);

        $reply = $discussion->replies()->create([
            ...$validated,
            'user_id' => auth()->id()
        ]);

        // Update discussion counts and activity
        $discussion->increment('replies_count');
        $discussion->update(['last_activity_at' => now()]);

        // Update category counts
        $discussion->category()->increment('replies_count');
        $discussion->category()->update(['last_activity_at' => now()]);

        return back()->with('success', 'Reply added successfully!');
    }

    public function updateReply(Request $request, DiscussionReply $reply)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.show', $reply->discussion)
            ]);
        }

        $this->authorize('update', $reply);

        $validated = $request->validate([
            'body' => 'required|string'
        ]);

        $reply->update($validated);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Reply updated successfully!']);
        }

        return redirect()->route('noccea.community.discussions.show', $reply->discussion)->with('success', 'Reply updated successfully!');
    }

    public function destroyReply(DiscussionReply $reply)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.show', $reply->discussion)
            ]);
        }

        $this->authorize('delete', $reply);

        $discussion = $reply->discussion;
        $reply->delete();

        // Update counts
        $discussion->decrement('replies_count');

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Reply deleted successfully!']);
        }

        return back()->with('success', 'Reply deleted successfully!');
    }

    public function markBestAnswer(DiscussionReply $reply)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.show', $reply->discussion)
            ]);
        }

        $discussion = $reply->discussion;
        $this->authorize('update', $discussion);

        $reply->markAsBestAnswer();

        return back()->with('success', 'Reply marked as best answer!');
    }

    public function vote(Request $request, Discussion $discussion)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $request->validate([
            'type' => 'required|in:upvote,downvote'
        ]);

        $result = DiscussionVote::toggle(auth()->user(), $discussion, $request->type);

        return response()->json([
            'success' => true,
            'action' => $result['action'],
            'upvotes' => $discussion->fresh()->upvotes_count,
            'downvotes' => $discussion->fresh()->downvotes_count,
            'score' => $discussion->fresh()->score
        ]);
    }

    public function voteReply(Request $request, DiscussionReply $reply)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $request->validate([
            'type' => 'required|in:upvote,downvote'
        ]);

        $result = DiscussionVote::toggle(auth()->user(), $reply, $request->type);

        return response()->json([
            'success' => true,
            'action' => $result['action'],
            'upvotes' => $reply->fresh()->upvotes_count,
            'downvotes' => $reply->fresh()->downvotes_count,
            'score' => $reply->fresh()->score
        ]);
    }

    public function bookmark(Discussion $discussion)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Authentication required'], 401);
        }

        $user = auth()->user();

        if ($user->bookmarkedDiscussions()->where('discussion_id', $discussion->id)->exists()) {
            $user->bookmarkedDiscussions()->detach($discussion->id);
            $bookmarked = false;
        } else {
            $user->bookmarkedDiscussions()->attach($discussion->id);
            $bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked
        ]);
    }

    public function bookmarksIndex()
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.bookmarks.index')
            ]);
        }

        $bookmarkedDiscussions = auth()->user()
            ->bookmarkedDiscussions()
            ->with(['user', 'category', 'bestReply.user'])
            ->withCount('replies')
            ->orderBy('discussion_bookmarks.created_at', 'desc')
            ->paginate(15);

        return view('noccea.community.bookmarks.index', compact('bookmarkedDiscussions'));
    }

    public function createReply(Discussion $discussion)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.show', $discussion)
            ]);
        }

        return view('noccea.community.replies.create', compact('discussion'));
    }

    public function editReply(DiscussionReply $reply)
    {
        // Check if user is authenticated after JWT middleware has run
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified', [
                'return' => route('noccea.community.discussions.show', $reply->discussion)
            ]);
        }

        $this->authorize('update', $reply);

        $discussion = $reply->discussion;

        return view('noccea.community.replies.edit', compact('reply', 'discussion'));
    }
}
