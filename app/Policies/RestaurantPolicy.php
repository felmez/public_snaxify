<?php

namespace App\Policies;

use App\Restaurant;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
{
    use HandlesAuthorization;

    protected function canAccessCityId(User $user, Restaurant $restaurant)
    {
        // $allow_cities = true;
        // if (Settings::getSettings()->multiple_cities) {
        //     $allow_cities = in_array($restaurant->city_id, $user->cities->pluck('id')->all());
        // }
        // return $user->access_full || ($user->access_restaurants && $allow_cities);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can view the restaurant.
     *
     * @param  \App\User       $user
     * @param  \App\Restaurant $restaurant
     *
     * @return mixed
     */
    public function view(User $user, Restaurant $restaurant)
    {
        // return $this->canAccessCityId($user, $restaurant);
        // wowo authorize roles to view if he is the user is owner and or admin etc..
        // if ($user->username === $restaurant->username) {
        //     return true;
        // }
        // if ($user->username === $restaurant->username) {
        //     return true;
        // }
        // // FIXME
        // return in_array($user->role_id, [
        //     'admin',
        //     // to prevent owner creating restaurants
        //     // FIXME: whole page gone if not admin
        //     // 'owner'
        // ]);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }
    // testing
    // public function show(Request $request, Post $restaurant)
    // {
    //     // controller authorization helper
    //     $this->authorize('view', $restaurant);
    //     // user authorization helper
    //     if ($request->user()->cant('view', $post)) {
    //         // return redirect / throw exception
    //     }
    // }

    /**
     * Determine whether the user can create restaurants.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        // FIXME: pls
        // return $user->access_full || $user->access_restaurants;
        // if ($user->username === $restaurant->username) {
        //     return true;
        // }
        // nice authorize roles to create if admin etc..
        // , [] array removed for no condition more than one
        return in_array($user->role_id, [
            'Admin',
        ]);
        // to prevent owner creating restaurants
        // FIXME: whole page gone if not admin
        // 'owner', TODO:
    }

    /**
     * Determine whether the user can update the restaurant.
     *
     * @param  \App\User       $user
     * @param  \App\Restaurant $restaurant
     *
     * @return mixed
     */
    public function update(User $user, Restaurant $restaurant)
    {
        // return $this->canAccessCityId($user, $restaurant);
        // wowo authorize roles to edit if he is the user is owner and or admin etc..
        // if ($user->username === $restaurant->owner_username) {
        //     return true;
        // }
        // return in_array($user->role_id, [
        //     'admin',
        //     // to prevent owner creating restaurants
        //     // FIXME: whole page gone if not admin
        //     // 'owner'
        // ]);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can delete the restaurant.
     *
     * @param  \App\User       $user
     * @param  \App\Restaurant $restaurant
     *
     * @return mixed
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        // BUG authorize changed by name due unique id while creating restaurant by admin then owner id does not match
        // return $this->canAccessCityId($user, $restaurant);
        // wowo authorize roles to delete if he is the user is owner and or admin etc..
        // if ($user->username === $restaurant->owner_username) {
        //     return true;
        // }
        // return in_array($user->role_id, [
        //     'admin',
        //     // to prevent owner creating restaurants
        //     // FIXME: whole page gone if not admin
        //     // 'owner'
        // ]);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }
}
