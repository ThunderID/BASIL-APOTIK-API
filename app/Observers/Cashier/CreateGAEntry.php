<?php

namespace App\Observers\Cashier;

use Illuminate\Validation\ValidationException;
use DB;

use \Thunderlabid\Cashier\CashierLog;
use \App\Account;
use \App\AccountEntry;

class CreateGAEntry
{
    //
    public function saved(CashierLog $log)
    {
    	if(!is_null($log->ref_type) && str_is(get_class(app()->make($log->ref_type)), get_class(app()->make(Account::class))) ){
	    	$acc_entry 	= AccountEntry::firstornew(['ga_id' => $log->ref_id, 'ref_id' => $log->id, 'ref_type' => get_class($log)]);
	    	$acc_entry->fill(['ga_id' => $log->ref_id, 'ref_id' => $log->id, 'ref_type' => get_class($log), 'description' => 'Pay via cashier', 'amount' => $log->amount * -1]);
	    	$acc_entry->save();
    	}
    }
}
