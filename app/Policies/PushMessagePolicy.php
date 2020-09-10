<?php

namespace App\Policies;

use App\PushMessage;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PushMessagePolicy
{
    use HandlesAuthorization;

    protected function canAccessCityId(User $user, Product $product)
    {
        // return $user->access_full || $user->access_pushes;
        // $allow_cities = true;
        // if (Settings::getSettings()->multiple_cities) {
        //     $allow_cities = in_array($product->city_id, $user->cities->pluck('id')->all());
        // }
        // return $user->access_full || ($user->access_products && $allow_cities);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can view the pushMessage.
     *
     * @param  \App\User        $user
     * @param  \App\PushMessage $pushMessage
     *
     * @return mixed
     */
    public function view(User $user, PushMessage $pushMessage)
    {
        // return $this->canAccessCityId($user, $pushMessage);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can create pushMessages.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        // return $user->access_full || $user->access_pushes;
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can update the pushMessage.
     *
     * @param  \App\User        $user
     * @param  \App\PushMessage $pushMessage
     *
     * @return mixed
     */
    public function update(User $user, PushMessage $pushMessage)
    {
        // return $this->canAccessCityId($user, $pushMessage);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can delete the pushMessage.
     *
     * @param  \App\User        $user
     * @param  \App\PushMessage $pushMessage
     *
     * @return mixed
     */
    public function delete(User $user, PushMessage $pushMessage)
    {
        // return $this->canAccessCityId($user, $pushMessage);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }
}
