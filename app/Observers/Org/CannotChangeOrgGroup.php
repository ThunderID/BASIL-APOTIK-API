<?php

namespace App\Observers\Org;

use Illuminate\Validation\ValidationException;
use DB;

use \App\Org;
use \App\RoomAvailability;

class CannotChangeOrgGroup
{
    //
    public function updating(Org $org)
    {
    	if ($org->getOriginal('org_group_id') != $org->org_group_id)
    	{
    		throw ValidationException::withMessages(['org_group_id' => 'immutable']);
    	}
    }
}
