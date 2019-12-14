<?php

namespace App\Policies\Accounting;

use App\User;
use Thunderlabid\Accounting\COA;
use Illuminate\Auth\Access\HandlesAuthorization;

class COAPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\COA  $coa
     * @return mixed
     */
    public function view(User $user, COA $coa)
    {
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, COA $coa)
    {
        $org = $coa->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_hotel->firstWhere('org_id', '=', $coa->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ACCOUNTING*', 'ACCOUNTING.COA']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Determine whether the user can update the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\COA  $coa
     * @return mixed
     */
    public function update(User $user, COA $coa)
    {
        $org = $coa->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_hotel->firstWhere('org_id', '=', $coa->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ACCOUNTING*', 'ACCOUNTING.COA']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\COA  $coa
     * @return mixed
     */
    public function delete(User $user, COA $coa)
    {
        $org = $coa->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;
        
        $work = $user->works_in_hotel->firstWhere('org_id', '=', $coa->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ACCOUNTING*', 'ACCOUNTING.COA']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\COA  $coa
     * @return mixed
     */
    public function restore(User $user, COA $coa)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\COA  $coa
     * @return mixed
     */
    public function forceDelete(User $user, COA $coa)
    {
        //
        return false;
    }
}
