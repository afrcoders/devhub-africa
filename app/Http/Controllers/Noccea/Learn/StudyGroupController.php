<?php

namespace App\Http\Controllers\Noccea\Learn;

use App\Http\Controllers\Controller;
use App\Models\Noccea\Learn\StudyGroup;
use App\Models\Noccea\Learn\StudyGroupMessage;
use App\Models\Noccea\Learn\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = StudyGroup::with(['creator', 'members'])
            ->where('is_active', true);

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $studyGroups = $query->latest()->paginate(12);

        $categories = Course::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('noccea.learn.study-groups.index', compact('studyGroups', 'categories'));
    }

    public function create()
    {
        // Only admins can create study groups
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only administrators can create study groups.');
        }

        $categories = Course::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('noccea.learn.study-groups.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Only admins can create study groups
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only administrators can create study groups.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'next_meeting_at' => 'nullable|date',
            'meeting_link' => 'nullable|url',
            'max_members' => 'required|integer|min:2|max:100',
        ]);

        $studyGroup = StudyGroup::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'created_by' => Auth::id(),
            'next_meeting_at' => $validated['next_meeting_at'] ?? null,
            'meeting_link' => $validated['meeting_link'] ?? null,
            'max_members' => $validated['max_members'],
            'is_active' => true,
        ]);

        // Automatically add creator as admin member
        $studyGroup->members()->attach(Auth::id(), ['role' => 'admin']);

        return redirect()->route('noccea.learn.study-groups.show', $studyGroup)
            ->with('success', 'Study group created successfully!');
    }

    public function show(StudyGroup $studyGroup)
    {
        $studyGroup->load(['creator', 'members']);

        $isMember = $studyGroup->isMember(Auth::id());
        $isAdmin = $studyGroup->isAdmin(Auth::id());

        // Load messages with user info, ordered by newest first
        $messages = $studyGroup->messages()->with('user')->latest()->get();

        return view('noccea.learn.study-groups.show', compact('studyGroup', 'isMember', 'isAdmin', 'messages'));

        if ($studyGroup->isMember(Auth::id())) {
            return back()->with('error', 'You are already a member of this study group.');
        }

        $studyGroup->members()->attach(Auth::id(), ['role' => 'member']);

        return back()->with('success', 'You have successfully joined the study group!');
    }

    public function leave(StudyGroup $studyGroup)
    {
        if (!$studyGroup->isMember(Auth::id())) {
            return back()->with('error', 'You are not a member of this study group.');
        }

        // Prevent the creator/admin from leaving their own group
        if ($studyGroup->created_by === Auth::id()) {
            return back()->with('error', 'You cannot leave a study group you created. Delete it instead.');
        }

        $studyGroup->members()->detach(Auth::id());

        return redirect()->route('noccea.learn.study-groups.index')
            ->with('success', 'You have left the study group.');
    }

    public function edit(StudyGroup $studyGroup)
    {
        // Only creator can edit
        if ($studyGroup->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Course::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('noccea.learn.study-groups.edit', compact('studyGroup', 'categories'));
    }

    public function update(Request $request, StudyGroup $studyGroup)
    {
        // Only creator can update
        if ($studyGroup->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'next_meeting_at' => 'nullable|date',
            'meeting_link' => 'nullable|url',
            'max_members' => 'required|integer|min:2|max:100',
            'is_active' => 'boolean',
        ]);

        $studyGroup->update($validated);

        return redirect()->route('noccea.learn.study-groups.show', $studyGroup)
            ->with('success', 'Study group updated successfully!');
    }

    public function destroy(StudyGroup $studyGroup)
    {
        // Only creator can delete
        if ($studyGroup->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $studyGroup->delete();

        return redirect()->route('noccea.learn.study-groups.index')
            ->with('success', 'Study group deleted successfully.');
    }

    public function postMessage(Request $request, StudyGroup $studyGroup)
    {
        // Only members can post
        if (!$studyGroup->isMember(Auth::id())) {
            return back()->with('error', 'You must be a member to post messages.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        StudyGroupMessage::create([
            'study_group_id' => $studyGroup->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Message posted successfully!');
    }

    public function deleteMessage(StudyGroup $studyGroup, StudyGroupMessage $message)
    {
        // Only message owner or group admin can delete
        if ($message->user_id !== Auth::id() && !$studyGroup->isAdmin(Auth::id())) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure message belongs to this study group
        if ($message->study_group_id !== $studyGroup->id) {
            abort(404);
        }

        $message->delete();

        return back()->with('success', 'Message deleted successfully.');
    }

    public function updateMessage(Request $request, StudyGroup $studyGroup, StudyGroupMessage $message)
    {
        // Only message owner or group admin can edit
        if ($message->user_id !== Auth::id() && !$studyGroup->isAdmin(Auth::id())) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure message belongs to this study group
        if ($message->study_group_id !== $studyGroup->id) {
            abort(404);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $message->update([
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Message updated successfully.');
    }
}
