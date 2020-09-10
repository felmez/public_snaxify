<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    protected function can(User $user, User $user2)
    {
        return $user->access_full || $user->access_users;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User $user
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function view(User $user, User $user2)
    {
        return $this->can($user, $user2);
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->can($user, new User());
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User $user
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function update(User $user, User $user2)
    {
        return $this->can($user, $user2);
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User $user
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function delete(User $user, User $user2)
    {
        return $this->can($user, $user2);
    }
}
