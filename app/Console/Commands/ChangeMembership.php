<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Partner;
use App\User;
use App\OrgSetting;
use App\Models\Membership\Membership;
use App\Models\Membership\MemberPoint;

class ChangeMembership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:levelling';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ubah membership level berdasarkan gross revenue';

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
        $ids    = config()->get('automation.membership.org_group_ids');
        $date   = now();
        $start  = Carbon::parse('first day of january '.$date->format('Y'))->startofday();
        $end    = Carbon::parse('last day of december '.$date->format('Y'))->endofday();

        foreach ($ids as $org_group_id) {
            $sett       = OrgSetting::wherehas('org_group', function($q)use($org_group_id){$q->where('id', $org_group_id);})
                ->where('active_at', '<=', $date)
                ->orderby('active_at', 'asc')
                ->orderby('created_at', 'desc')
                ->first();

            //LEVEL UP USER
            $users      = User::get();
            foreach ($users as $v) {
                $member     = $v->memberships->where('org_group_id', $org_group_id)->where('started_at', '<=', $date)->orderby('started_at', 'desc')->orderby('created_at', 'desc')->first();

                $net_revenue= MemberPoint::where('org_group_id', $org_group_id)->where('user_id', $v->id)->where('date', '>=', $start)->where('date', '<=', $end)->sum('net_revenue');

                // $rate_table = config()->get('automation.membership.user_rate_table.'.$org_group_id);

                $level      = 'silver';
                foreach ($sett->setting['membership']['guest'] as $v2) {
                    //1. 
                    if((is_null($v2['min']) || $net_revenue >= $v2['min']) && (is_null($v2['max']) || $net_revenue < $v2['max'])){
                        $level  = $v2['level'];
                    }
                }

                Membership::create(['user_id' => $v->id, 'started_at' => $date, 'level' => $level, 'org_group_id' => $org_group_id]);
            }
            
    
            //LEVEL UP PARTNER
            $partners      = Partner::where('org_group_id', $org_group_id)->get();
            foreach ($partners as $v) {
                $member     = $v->memberships->where('org_group_id', $org_group_id)->where('started_at', '<=', $date)->orderby('started_at', 'desc')->orderby('created_at', 'desc')->first();

                $net_revenue= MemberPoint::where('org_group_id', $org_group_id)->where('user_id', $v->id)->where('date', '>=', $start)->where('date', '<=', $end)->sum('net_revenue');

                $level      = 'silver';
                foreach ($sett->setting['membership']['partner'] as $v2) {
                    //1. 
                    if((is_null($v2['min']) || $net_revenue >= $v2['min']) && (is_null($v2['max']) || $net_revenue < $v2['max'])){
                        $level  = $v2['level'];
                    }
                }

                Membership::create(['partner_id' => $v->id, 'started_at' => $date, 'level' => $level, 'org_group_id' => $org_group_id]);
            }
        }

    }
}
