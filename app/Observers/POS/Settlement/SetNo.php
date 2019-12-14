<?php

namespace App\Observers\POS\Settlement;

use Illuminate\Validation\ValidationException;
use DB;

use \Thunderlabid\POS\Settlement;

class SetNo
{
    //
    public function saving(Settlement $set)
    {
        if(is_null($set->no) && !is_null($set->date)){
            $set->no     		= $set->generateNo();
            // $set->issued_at	 	= now();
        }
    }
}
