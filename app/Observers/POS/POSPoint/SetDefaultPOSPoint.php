<?php

namespace App\Observers\POS\POSPoint;

use Illuminate\Validation\ValidationException;
use DB;

use \App\Org;
use \Thunderlabid\POS\POSPoint;

class SetDefaultPOSPoint
{
    public function created(Org $org){
    	$point        = POSPoint::where('org_id', $org->id)->first();
        if(!$point){
            $point    = new POSPoint;
        }
        $point->org_id= $org->id;
        $point->name  = $org->name.' POS';
        $point->category    = 'PHARMACEUTICAL';
        $point->is_active   = true;
        $point->save();
    }
}
