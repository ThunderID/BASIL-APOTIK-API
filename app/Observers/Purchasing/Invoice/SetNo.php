<?php

namespace App\Observers\Purchasing\Invoice;

use Illuminate\Validation\ValidationException;
use DB;

use \App\Models\Purchasing\Invoice;

class SetNo
{
    //
    public function saving(Invoice $inv)
    {
        if(is_null($inv->no) && !is_null($inv->issued_at)){
            $inv->no     		= $inv->generateNo();
            // $inv->issued_at	 	= now();
        }
    }
}
