<?php

namespace App\Http\Controllers;

use Gate, Auth, Exception;
use Aws\Rekognition\RekognitionClient as AWS;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Pricing\RoomRate;
use App\Models\Pricing\RoomType;
use \App\Models\Membership\MemberPoint;

class PartnerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function point(Request $request){
        try {
            if(!Auth::check()) {
                app()->abort(403);
            }

            $args   = $request->only(['start', 'end', 'partner_id']);

            $point  = MemberPoint::where('partner_id', $args['partner_id'])
                ->where('date', '>=', Carbon::parse($args['start']))
                ->where('date', '<=', Carbon::parse($args['end']))
                ->get();

            return response()->json(['status' => 'success', 'data' => $point]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    public function rate(Request $request){
        try {
            if(!Auth::check()) {
                app()->abort(403);
            }

            $args   = $request->only(['start', 'end']);
            $start  = Carbon::parse($args['start']);
            $end    = Carbon::parse($args['end']);

            $rt     = RoomType::get();
            $data   = null;

            foreach ($rt as $v) {
                $q      = new RoomRate;
                $q      = $q->selectraw('max(created_at) as created_at')
                ->selectraw("
                    (SELECT rr2.price FROM ".(new RoomRate)->getTable()." as rr2 WHERE room_rates.room_type_id = rr2.room_type_id AND room_rates.started_at = rr2.started_at order by created_at desc limit 1) as price
                ")->selectraw("
                    (SELECT rr2.discount FROM ".(new RoomRate)->getTable()." as rr2 WHERE room_rates.room_type_id = rr2.room_type_id AND room_rates.started_at = rr2.started_at order by created_at desc limit 1) as discount
                ");

                $q      = $q->where('started_at', '<=', $end)->where('room_type_id', $v['id']);
                $q      = $q->selectraw('started_at')->groupby('room_type_id')->groupby('started_at')->get();

                $daterange  = new \DatePeriod($start, new \DateInterval('P1D'), $end);

                foreach($daterange as $k => $date){
                    $rate   = $q->where('started_at', '<=', $date)->sortbydesc('started_at')->sortbydesc('created_at')->first();
               
                    if(!is_null($rate)){
                        $data[$k]               = $rate->toarray();
                        $data[$k]['date']       = (string)$date; 
                        $data[$k]['room_type']  = $v->toarray();  
                    }elseif(isset($data[$k-1])){
                        $data[$k]               = $data[$k-1];
                        $data[$k]['date']       = (string)$date; 
                        $data[$k]['room_type']  = $v->toarray();  
                    }else{
                        $data[$k]['room_type']  = $v->toarray();  
                        $data[$k]['price']      = 0;  
                        $data[$k]['discount']   = 0;  
                        $data[$k]['net']        = 0;
                        $data[$k]['date']       = $date; 
                    }
                }
            }


            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
