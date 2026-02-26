<?php

namespace App\Policies;

use App\Models\Community\Discussion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiscussionPolicy
{
    /**
     * Determine whether the user can view any discussions.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the discussion.
     */
    public function view(?User $user, Discussion $discussion): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create discussions.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the discussion.
     */
    public function update(User $user, Discussion $discussion): bool
    {
        // User can edit their own discussion or if they're admin
        return $user->id === $discussion->user_id || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the discussion.
     */
    public function delete(User $user, Discussion $discussion): bool
    {
        // User can delete their own discussion or if they're admin
        return $user->id === $discussion->user_id || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can restore the discussion.
     */
    public function restore(User $user, Discussion $discussion): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the discussion.
     */
    public function forceDelete(User $user, Discussion $discussion): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Check if user is admin
     */
    private function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }
}
