<?php

namespace App\Policies;

use App\Models\Community\DiscussionReply;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DiscussionReplyPolicy
{
    /**
     * Determine whether the user can view any discussion replies.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the discussion reply.
     */
    public function view(?User $user, DiscussionReply $reply): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create discussion replies.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the discussion reply.
     */
    public function update(User $user, DiscussionReply $reply): bool
    {
        // User can edit their own reply or if they're admin
        return $user->id === $reply->user_id || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can delete the discussion reply.
     */
    public function delete(User $user, DiscussionReply $reply): bool
    {
        // User can delete their own reply or if they're admin
        return $user->id === $reply->user_id || $this->isAdmin($user);
    }

    /**
     * Determine whether the user can restore the discussion reply.
     */
    public function restore(User $user, DiscussionReply $reply): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * Determine whether the user can permanently delete the discussion reply.
     */
    public function forceDelete(User $user, DiscussionReply $reply): bool
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
