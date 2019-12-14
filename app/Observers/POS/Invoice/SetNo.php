<?php

namespace App\Observers\POS\Invoice;

use Illuminate\Validation\ValidationException;
use DB;

use \Thunderlabid\POS\Invoice;

class SetNo
{
    //
    public function saving(Invoice $inv)
    {
        if(is_null($inv->no) && !is_null($inv->date)){
            $inv->no     		= $inv->generateNo();
            // $inv->issued_at	 	= now();
        }
    }
}
