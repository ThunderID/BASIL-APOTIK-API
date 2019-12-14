<?php

namespace App\Policies;

use App\User;
use App\OrgSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrgSettingPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\OrgSetting  $setting
     * @return mixed
     */
    public function view(User $user, OrgSetting $setting)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, OrgSetting $setting)
    {
        //
        return $setting->org->org_group->owner_id == $user->id;
    }

    /**
     * Determine whether the user can update the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\OrgSetting  $setting
     * @return mixed
     */
    public function update(User $user, OrgSetting $setting)
    {
        //
        return $setting->org->org_group->owner_id == $user->id;
    }

    /**
     * Determine whether the user can delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\OrgSetting  $setting
     * @return mixed
     */
    public function delete(User $user, OrgSetting $setting)
    {
        //
        return $setting->org->org_group->owner_id == $user->id;
    }

    /**
     * Determine whether the user can restore the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\OrgSetting  $setting
     * @return mixed
     */
    public function restore(User $user, OrgSetting $setting)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\OrgSetting  $setting
     * @return mixed
     */
    public function forceDelete(User $user, OrgSetting $setting)
    {
        //
        return false;
    }
}
