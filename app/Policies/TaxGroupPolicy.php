<?php

namespace App\Policies;

use App\TaxGroup;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxGroupPolicy
{
    use HandlesAuthorization;

    protected function tgAccess(User $user, TaxGroup $taxGroup)
    {
        // return $user->access_full || $user->access_tax_groups;
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can view the taxGroup.
     *
     * @param  \App\User     $user
     * @param  \App\TaxGroup $taxGroup
     *
     * @return mixed
     */
    public function view(User $user, TaxGroup $taxGroup)
    {
        // return $this->tgAccess($user, $taxGroup);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can create taxGroups.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        // return $this->tgAccess($user, new TaxGroup());
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can update the taxGroup.
     *
     * @param  \App\User     $user
     * @param  \App\TaxGroup $taxGroup
     *
     * @return mixed
     */
    public function update(User $user, TaxGroup $taxGroup)
    {
        // return $this->tgAccess($user, $taxGroup);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can delete the taxGroup.
     *
     * @param  \App\User     $user
     * @param  \App\TaxGroup $taxGroup
     *
     * @return mixed
     */
    public function delete(User $user, TaxGroup $taxGroup)
    {
        // return $this->tgAccess($user, $taxGroup);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }
}
