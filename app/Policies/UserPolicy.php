<?php

namespace App\Policies;

use App\User;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user2
     * @return mixed
     */
    public function view(User $user, User $user2)
    {
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user2
     * @return mixed
     */
    public function update(User $user, User $user2)
    {
        return $user->id == $user2->id;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user2
     * @return mixed
     */
    public function delete(User $user, User $user)
    {
        return $user->id == $user2->id;
    }

    public function before($user, $ability)
    {
        if ($user->level == 10) {
            return true;
        }
    }
}
