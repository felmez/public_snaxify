<?php

namespace App\Policies;

use App\DeliveryArea;
use App\Settings;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryAreaPolicy
{
    use HandlesAuthorization;

    protected function canAccessCityId(User $user, DeliveryArea $area)
    {
        $allow_cities = true;
        if (Settings::getSettings()->multiple_cities) {
            $allow_cities = in_array($area->city_id, $user->cities->pluck('id')->all());
        }

        return $user->access_full || ($user->access_delivery_areas && $allow_cities);
    }

    /**
     * Determine whether the user can view the deliveryArea.
     *
     * @param  \App\User         $user
     * @param  \App\DeliveryArea $deliveryArea
     *
     * @return mixed
     */
    public function view(User $user, DeliveryArea $deliveryArea)
    {
        // return $this->canAccessCityId($user, $deliveryArea);
        // FIXME:
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can create deliveryAreas.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->access_full || $user->access_delivery_areas;
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can update the deliveryArea.
     *
     * @param  \App\User         $user
     * @param  \App\DeliveryArea $deliveryArea
     *
     * @return mixed
     */
    public function update(User $user, DeliveryArea $deliveryArea)
    {
        return $this->canAccessCityId($user, $deliveryArea);
        // wowo authorize roles to edit if he is the user is owner and or admin etc..
        // if ($user->username === $deliveryArea->owner_username) {
        //     return true;
        // }
        return in_array($user->role_id, [
            'Admin',
        ]);
        // return in_array($user->role, [
        //     'admin',
        //     // to prevent owner creating restaurants
        //     // FIXME: whole page gone if not admin
        //     // 'owner'
        // ]);
    }

    /**
     * Determine whether the user can delete the deliveryArea.
     *
     * @param  \App\User         $user
     * @param  \App\DeliveryArea $deliveryArea
     *
     * @return mixed
     */
    public function delete(User $user, DeliveryArea $deliveryArea)
    {
        return $this->canAccessCityId($user, $deliveryArea);
        // wowo authorize roles to edit if he is the user is owner and or admin etc..
        // if ($user->username === $deliveryArea->owner_username) {
        //     return true;
        // }
        return in_array($user->role_id, [
            'Admin',
        ]);
        // return in_array($user->role, [
        //     'admin',
        //     // to prevent owner creating restaurants
        //     // FIXME: whole page gone if not admin
        //     // 'owner'
        // ]);
    }
}
