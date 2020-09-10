<?php

namespace App\Policies;

use App\Settings;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingsPolicy
{
    use HandlesAuthorization;

    protected function sAccess(User $user, Settings $settings)
    {
        // return $user->access_full || $user->access_settings;
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can view the settings.
     *
     * @param  \App\User     $user
     * @param  \App\Settings $settings
     *
     * @return mixed
     */
    public function view(User $user, Settings $settings)
    {
        // return $this->sAccess($user, $settings);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can create settings.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        // return $this->sAccess($user, new Settings);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can update the settings.
     *
     * @param  \App\User     $user
     * @param  \App\Settings $settings
     *
     * @return mixed
     */
    public function update(User $user, Settings $settings)
    {
        // return $this->sAccess($user, $settings);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }

    /**
     * Determine whether the user can delete the settings.
     *
     * @param  \App\User     $user
     * @param  \App\Settings $settings
     *
     * @return mixed
     */
    public function delete(User $user, Settings $settings)
    {
        // return $this->sAccess($user, $settings);
        return in_array($user->role_id, [
            'Admin',
        ]);
    }
}
