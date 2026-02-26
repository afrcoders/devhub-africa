<?php

namespace App\Http\Controllers\Noccea\Learn;

use App\Http\Controllers\Controller;
use App\Models\Noccea\Learn\ForumQuestion;
use App\Models\Noccea\Learn\ForumAnswer;
use App\Models\Noccea\Learn\ForumVote;
use App\Models\Noccea\Learn\ForumBookmark;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $questions = ForumQuestion::with('user', 'course')
            ->latest()
            ->paginate(10);

        return view('noccea.learn.qa-forum.index', compact('questions'));
    }

    public function create()
    {
        return view('noccea.learn.qa-forum.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:10|max:200',
            'body' => 'required|string|min:20|max:5000',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        ForumQuestion::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'body' => $validated['body'],
            'course_id' => $validated['course_id'] ?? null,
        ]);

        return redirect()->route('noccea.learn.qa-forum.index')
            ->with('success', 'Question posted successfully!');
    }

    public function show(ForumQuestion $question)
    {
        $question->increment('views');
        $question->load('user', 'course', 'answers.user');

        return view('noccea.learn.qa-forum.show', compact('question'));
    }

    public function answerStore(Request $request, ForumQuestion $question)
    {
        $validated = $request->validate([
            'body' => 'required|string|min:10|max:5000',
        ]);

        ForumAnswer::create([
            'user_id' => auth()->id(),
            'question_id' => $question->id,
            'body' => $validated['body'],
        ]);

        return redirect()->route('noccea.learn.qa-forum.show', $question)
            ->with('success', 'Answer posted successfully!');
    }

    public function markAccepted(ForumQuestion $question, ForumAnswer $answer)
    {
        if ($question->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $question->answers()->update(['is_accepted' => false]);
        $answer->update(['is_accepted' => true]);
        $question->update(['answered_at' => now()]);

        return redirect()->back()->with('success', 'Answer marked as accepted!');
    }

    public function destroy(ForumQuestion $question)
    {
        if ($question->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $question->delete();

        return redirect()->route('noccea.learn.qa-forum.index')
            ->with('success', 'Question deleted successfully!');
    }

    // Voting endpoints
    public function vote(Request $request, ForumQuestion $question)
    {
        return $this->voteQuestion($request, $question);
    }

    public function voteQuestion(Request $request, ForumQuestion $question)
    {
        $voteType = $request->get('type'); // 'up' or 'down'
        $userId = auth()->id();

        $existingVote = $question->votes()
            ->where('user_id', $userId)
            ->first();

        if ($existingVote) {
            if (($voteType === 'up' && $existingVote->vote === 1) ||
                ($voteType === 'down' && $existingVote->vote === -1)) {
                // Remove vote if voting same direction
                $existingVote->delete();
            } else {
                // Update vote
                $existingVote->update(['vote' => $voteType === 'up' ? 1 : -1]);
            }
        } else {
            // Create new vote
            ForumVote::create([
                'user_id' => $userId,
                'voteable_id' => $question->id,
                'voteable_type' => ForumQuestion::class,
                'vote' => $voteType === 'up' ? 1 : -1,
            ]);
        }

        $question->updateVoteCount();

        return response()->json([
            'success' => true,
            'votes' => $question->votes,
            'userVote' => $question->userVote($userId),
        ]);
    }

    public function voteAnswer(Request $request, ForumQuestion $question, ForumAnswer $answer)
    {
        $voteType = $request->get('type'); // 'up' or 'down'
        $userId = auth()->id();

        $existingVote = $answer->votes()
            ->where('user_id', $userId)
            ->first();

        if ($existingVote) {
            if (($voteType === 'up' && $existingVote->vote === 1) ||
                ($voteType === 'down' && $existingVote->vote === -1)) {
                // Remove vote if voting same direction
                $existingVote->delete();
            } else {
                // Update vote
                $existingVote->update(['vote' => $voteType === 'up' ? 1 : -1]);
            }
        } else {
            // Create new vote
            ForumVote::create([
                'user_id' => $userId,
                'voteable_id' => $answer->id,
                'voteable_type' => ForumAnswer::class,
                'vote' => $voteType === 'up' ? 1 : -1,
            ]);
        }

        $answer->updateVoteCount();

        return response()->json([
            'success' => true,
            'votes' => $answer->votes,
            'userVote' => $answer->userVote($userId),
        ]);
    }

    public function bookmark(Request $request, ForumQuestion $question)
    {
        return $this->toggleBookmark($request, $question);
    }

    public function toggleBookmark(Request $request, ForumQuestion $question)
    {
        $userId = auth()->id();

        $bookmark = ForumBookmark::where('user_id', $userId)
            ->where('question_id', $question->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $isBookmarked = false;
        } else {
            ForumBookmark::create([
                'user_id' => $userId,
                'question_id' => $question->id,
            ]);
            $isBookmarked = true;
        }

        return response()->json([
            'success' => true,
            'isBookmarked' => $isBookmarked,
        ]);
    }

    // Answer CRUD Operations
    public function editAnswer(ForumQuestion $question, ForumAnswer $answer)
    {
        // Check authorization
        if ($answer->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        return view('noccea.learn.qa-forum.edit-answer', compact('question', 'answer'));
    }

    public function updateAnswer(Request $request, ForumQuestion $question, ForumAnswer $answer)
    {
        // Check authorization
        if ($answer->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'body' => 'required|string|min:10|max:5000',
        ]);

        $answer->update(['body' => $validated['body']]);

        return redirect()->route('noccea.learn.qa-forum.show', $question)
            ->with('success', 'Answer updated successfully!');
    }

    public function deleteAnswer(ForumQuestion $question, ForumAnswer $answer)
    {
        // Check authorization
        if ($answer->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $answer->delete();

        return redirect()->route('noccea.learn.qa-forum.show', $question)
            ->with('success', 'Answer deleted successfully!');
    }
}
