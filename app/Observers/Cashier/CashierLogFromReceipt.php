<?php

namespace App\Observers\Cashier;

use Illuminate\Validation\ValidationException;
use DB;
use Auth;

use \App\Models\Focashier\Receipt;

use Thunderlabid\Cashier\CashierSession;
use Thunderlabid\Cashier\CashierLog;

class CashierLogFromReceipt
{
    //
    public function saved(Receipt $receipt)
    {
        $ses = CashierSession::wherenull('closed_at')->where('org_id', $receipt['org_id'])->where('user_id', Auth::user()->id)->first();
        if(!$ses){
            throw ValidationException::withMessages(['cashier_session_id' => 'notfound']);
        }
        $log = CashierLog::firstornew(['ref_id' => $receipt['id'], 'cashier_session_id' => $ses->id, 'ref_type' => get_class($receipt)]);
        $log->cashier_session_id    = $ses->id;
        $log->method    = $receipt->method;
        $log->amount    = $receipt->amount;
        $log->ref_id    = $receipt->id;
        $log->ref_type  = get_class($receipt);
        $log->save();
    }
}
