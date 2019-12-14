<?php

namespace App\Observers\Purchasing\Invoice;

use Illuminate\Validation\ValidationException;
use DB;

use \App\Models\Purchasing\Invoice;

class SetTax
{
    //
    public function saving(Invoice $inv)
    {
    	$bill 	= 0;
    	foreach ($inv->lines as $v) {
    		$bill 	= $bill + (($v['price'] - $v['discount']) * $v['qty']);
    	}

        $inv->tax 	= ($bill - $inv->discount) * config()->get('tax.full');
    }
}
