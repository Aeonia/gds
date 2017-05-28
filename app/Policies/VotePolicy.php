<?php

namespace App\Policies;

use App\User;
use App\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;

class VotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the vote.
     *
     * @param  \App\User  $user
     * @param  \App\Vote  $vote
     * @return mixed
     */
    public function view(User $user, Vote $vote)
    {
        return true;
    }

    /**
     * Determine whether the user can create votes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->level >= 1;
    }

    /**
     * Determine whether the user can update the vote.
     *
     * @param  \App\User  $user
     * @param  \App\Vote  $vote
     * @return mixed
     */
    public function update(User $user, Vote $vote)
    {
        return $user->id == $vote->user_id;
    }

    /**
     * Determine whether the user can delete the vote.
     *
     * @param  \App\User  $user
     * @param  \App\Vote  $vote
     * @return mixed
     */
    public function delete(User $user, Vote $vote)
    {
        return $user->id == $vote->user_id;
    }

    public function before($user, $ability)
    {
        if ($user->level == 10) {
            return true;
        }
    }
}
