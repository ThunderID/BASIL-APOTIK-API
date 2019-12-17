<?php

namespace App\Observers\WMS\Warehouse;

use Illuminate\Validation\ValidationException;
use DB;

use \App\Org;
use \Thunderlabid\WMS\Warehouse;

class SetDefaultWarehouse
{
    public function created(Org $org){
    	$wh        = Warehouse::where('org_id', $org->id)->first();
        if(!$wh){
            $wh    = new Warehouse;
        }
        $wh->org_id= $org->id;
        $wh->name  = $org->name.' storage';
        $wh->department    = 'warehouse';
        $wh->is_active     = true;
        $wh->save();
    }
}
