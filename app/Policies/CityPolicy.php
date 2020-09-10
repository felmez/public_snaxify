<?php

namespace App\Policies;

use App\City;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

    protected function cAccess(User $user, City $city)
    {
        return $user->access_full || $user->access_cities;
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can view the city.
     *
     * @param  \App\User $user
     * @param  \App\City $city
     *
     * @return mixed
     */
    public function view(User $user, City $city)
    {
        return $this->cAccess($user, $city);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can create cities.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->cAccess($user, new City);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can update the city.
     *
     * @param  \App\User $user
     * @param  \App\City $city
     *
     * @return mixed
     */
    public function update(User $user, City $city)
    {
        return $this->cAccess($user, $city);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can delete the city.
     *
     * @param  \App\User $user
     * @param  \App\City $city
     *
     * @return mixed
     */
    public function delete(User $user, City $city)
    {
        return $this->cAccess($user, $city);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }
}
