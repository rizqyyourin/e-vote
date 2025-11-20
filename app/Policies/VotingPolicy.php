<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Voting;

class VotingPolicy
{
    /**
     * Determine if the user can update the voting.
     */
    public function update(User $user, Voting $voting): bool
    {
        return $user->id === $voting->admin_id;
    }

    /**
     * Determine if the user can delete the voting.
     */
    public function delete(User $user, Voting $voting): bool
    {
        return $user->id === $voting->admin_id;
    }

    /**
     * Determine if the user can view the voting.
     */
    public function view(User $user, Voting $voting): bool
    {
        // Public votings can be viewed by anyone
        return true;
    }
}
