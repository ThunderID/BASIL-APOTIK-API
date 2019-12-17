<?php

namespace App\Policies\Accounting;

use App\User;
use Thunderlabid\Accounting\JournalEntry;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalEntryPolicy
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
     * @param  \App\JournalEntry  $journal_entry
     * @return mixed
     */
    public function view(User $user, JournalEntry $journal_entry)
    {
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, JournalEntry $journal_entry)
    {
        $org = $journal_entry->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $journal_entry->org_id);
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
     * @param  \App\JournalEntry  $journal_entry
     * @return mixed
     */
    public function update(User $user, JournalEntry $journal_entry)
    {
        $org = $journal_entry->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $journal_entry->org_id);
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
     * @param  \App\JournalEntry  $journal_entry
     * @return mixed
     */
    public function delete(User $user, JournalEntry $journal_entry)
    {
        $org = $journal_entry->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $journal_entry->org_id);
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
     * @param  \App\JournalEntry  $journal_entry
     * @return mixed
     */
    public function restore(User $user, JournalEntry $journal_entry)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\JournalEntry  $journal_entry
     * @return mixed
     */
    public function forceDelete(User $user, JournalEntry $journal_entry)
    {
        //
        return false;
    }
}
