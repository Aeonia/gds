<?php

namespace App\Policies;

use App\User;
use App\ArticleVote;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleVotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the vote.
     *
     * @param  \App\User  $user
     * @param  \App\ArticleVote  $vote
     * @return mixed
     */
    public function view(User $user, ArticleVote $vote)
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
     * @param  \App\ArticleVote  $vote
     * @return mixed
     */
    public function update(User $user, ArticleVote $vote)
    {
        return $user->id == $vote->user_id;
    }

    /**
     * Determine whether the user can delete the vote.
     *
     * @param  \App\User  $user
     * @param  \App\ArticleVote  $vote
     * @return mixed
     */
    public function delete(User $user, ArticleVote $vote)
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
