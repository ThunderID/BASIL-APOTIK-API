<?php

namespace App\Observers\POS;

use Illuminate\Validation\ValidationException;
use DB;
use Auth;

use \Thunderlabid\POS\Settlement;

use Thunderlabid\Cashier\CashierSession;
use Thunderlabid\Cashier\CashierLog;

class CashierLogFromSettlement
{
    //
    public function saved(Settlement $set)
    {
        if(!str_is($set->type, Settlement::GUEST_ACCOUNT)){
            $ses = CashierSession::wherenull('closed_at')->where('org_id', $set->invoice->pos_point['org_id'])->where('user_id', Auth::user()->id)->first();
            if(!$ses){
                throw ValidationException::withMessages(['cashier_session_id' => 'notfound']);
            }
            $log = CashierLog::firstornew(['ref_id' => $set['id'], 'cashier_session_id' => $ses->id, 'ref_type' => get_class($set)]);
            $log->cashier_session_id    = $ses->id;
            $log->method    = $set->type;
            $log->amount    = $set->amount;
            $log->ref_id    = $set->id;
            $log->ref_type  = get_class($set);
            $log->save();
        }
    }
}
