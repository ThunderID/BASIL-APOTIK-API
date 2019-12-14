<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB, Exception, Log;
use App\Models\Record\Reservation;

class NightAudit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:night';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tandai no show';

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
        $date   = now()->adddays(1);
        
        $book   = Reservation::where('co_date', '<', $date->format('Y-m-d'))->wherehas('lines', function($q){
            $q->wherenull('ci_at');
        })->get();

        foreach ($book as $v) {
            try {
                DB::BeginTransaction();
                foreach ($v->lines as $v2) {
                    if(is_null($v2->ci_at)){
                        $v2->room_id     = null;
                        $v2->ci_at       = $date;
                        $v2->co_at       = $date;
                        $v2->save();
                    }
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                Log::info($e);
            }
        }
    }
}
