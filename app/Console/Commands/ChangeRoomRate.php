<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\OrgSetting;
use App\Models\Pricing\RoomType;
use App\Models\Pricing\RoomRate;

class ChangeRoomRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'room:rate {--room_type_id=} {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ubah room rate berdasarkan occupancy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ids    = config()->get('automation.rate.org_ids');
        $date   = now();

        foreach ($ids as $org_id) {
            $types      = RoomType::where('org_id', $org_id)->get();
            $sett       = OrgSetting::where('org_id', $org_id)
                ->where('active_at', '<=', $date)
                ->orderby('active_at', 'asc')
                ->orderby('created_at', 'desc')
                ->first();
    
            foreach ($types as $v) {
                //1. HITUNG OCCUPANCY
                $occ        = (count($v->roomsOccupied()) / max(1, $v->rooms()->count())) *100;

                //2. HITUNG PERUBAHAN RATE
                //2A. GET ORIGINAL RATE
                if(!$v->is_partnership_program){
                    $normal = $sett['setting']['fo']['normal_rate'];
                    $bf     = $sett['setting']['fnb']['breakfast_normal_rate'];
                    if(in_array(strtolower($date->format('l')), ['saturday', 'sunday'])){
                        $normal = $sett['setting']['fo']['weekend_rate'];
                        $bf     = $sett['setting']['fnb']['breakfast_weekend_rate'];
                    }
                }else{
                    $normal = $sett['setting']['fo']['ota_normal_rate'];
                    $bf     = $sett['setting']['fnb']['breakfast_normal_rate'];
                    if(in_array(strtolower($date->format('l')), ['saturday', 'sunday'])){
                        $normal = $sett['setting']['fo']['ota_weekend_rate'];
                        $bf     = $sett['setting']['fnb']['breakfast_weekend_rate'];
                    }
                }


                //2B. GET RATE TABLE
                $rate       = $sett['setting']['fo']['rate'];
                $price      = $normal;

                foreach ($rate as $v2) {
                    if($occ >= $v2['min_occupancy_in_percentage'] && $occ < $v2['max_occupancy_in_percentage']){
                        $price  = $normal + ($normal * ($v2['increase_rate_in_percentage']/100));
                    }
                }
                // $mult       = $sett['setting']['fo']['occupancy_multiply_in_percent'];
                // $perc       = $sett['setting']['fo']['increase_rate_in_percent'];
                
                // $occ        = floor($occ/max(1,$mult));
                // $occ        = ($occ * $perc)/100;
                // $price      = $normal + ($normal* $occ);

                //2C. GET BREAKFAST
                $price  = $price + ($v->facilities['breakfast'] * $bf);

                if($price!=$v->room_rate->price){
                    //3. SIMPAN RATE
                    RoomRate::create(['room_type_id' => $v->id, 'price' => $price, 'discount' => $v->room_rate->discount, 'started_at' => now()]); 
                }
            }
        }

    }
}
