<?php

namespace App\Policies;

use App\OrderStatus;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderStatusPolicy
{
    use HandlesAuthorization;

    // protected function cAccess(User $user, OrderStatus $order_status)
    // {
    //     return $user->access_full || $user->access_order_statuses;
    // }

    /**
     * Determine whether the user can view the order_status.
     *
     * @param  \App\User $user
     * @param  \App\City $order_status
     *
     * @return mixed
     */
    public function view(User $user, OrderStatus $order_status)
    {
        // return $this->cAccess($user, $order_status);
        // FIXME:
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
        // return $this->cAccess($user, new order_status);
        // return $user->access_full || $user->access_order_statuses;
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can update the order_status.
     *
     * @param  \App\User        $user
     * @param  \App\OrderStatus $order_status
     *
     * @return mixed
     */
    public function update(User $user, OrderStatus $order_status)
    {
        // return $this->cAccess($user, $order_status);
        // wowo authorize roles to edit if he is the user is owner and or admin etc..
        // if ($user->username === $order_status->owner_username) {
        //     return true;
        // }
        return in_array($user->role_id, [
            'Admin',
        ]);
        // return in_array($user->role_id, [
        //     'admin',
        //     // to prevent owner creating restaurants
        //     // FIXME: whole page gone if not admin
        //     // 'owner'
        // ]);
    }

    /**
     * Determine whether the user can delete the order_status.
     *
     * @param  \App\User        $user
     * @param  \App\OrderStatus $order_status
     *
     * @return mixed
     */
    public function delete(User $user, OrderStatus $order_status)
    {
        // return $this->cAccess($user, $order_status);
        // wowo authorize roles to edit if he is the user is owner and or admin etc..
        // if ($user->username === $oder_status->owner_username) {
        //     return true;
        // }
        return in_array($user->role_id, [
            'Admin',
        ]);
        // return in_array($user->role_id, [
        //     'admin',
        //     // to prevent owner creating restaurants
        //     // FIXME: whole page gone if not admin
        //     // 'owner'
        // ]);
    }
}
