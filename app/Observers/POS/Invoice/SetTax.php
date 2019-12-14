<?php

namespace App\Observers\POS\Invoice;

use Illuminate\Validation\ValidationException;
use DB;

use \Thunderlabid\POS\Invoice;

class SetTax
{
    //
    public function saving(Invoice $inv)
    {
    	$bill 	= 0;
    	foreach ($inv->lines as $v) {
    		$bill 	= $bill + (($v['price'] - $v['discount']) * $v['qty']);
    	}

        $taxes[] = ($bill - $inv->discount) * config()->get('tax.full');
    }
}
