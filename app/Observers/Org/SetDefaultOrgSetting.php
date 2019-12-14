<?php

namespace App\Observers\Org;

use Illuminate\Validation\ValidationException;
use DB;

use \App\Org;
use \App\OrgSetting;

class SetDefaultOrgSetting
{
    public function saved(Org $org){
    	OrgSetting::create([
    		'org_id' 	=> $org->id, 
    		'active_at' => now(), 
    		'setting' 	=> [
                'target'        => [
                    'monthly_guest_aquisition'  => 100,
                ],
                'fo'            => [
                    'payment_credit_card'       => ['AMEX', 'BCA', 'MANDIRI'],
                    'payment_debit_card'        => ['BNI', 'BCA', 'MANDIRI'],
                    'checkin_in_hour'           => 14,
                    'checkout_in_hour'          => 12,
                    'checkin'   => [
                        ['min_in_hour' => 0, 'max_in_hour' => 6, 'amount' => 80000, 'breakfast' => true],
                        ['min_in_hour' => 6, 'max_in_hour' => 11, 'amount' => 80000, 'breakfast' => true],
                        ['min_in_hour' => 11,'max_in_hour' => 23, 'amount' => 0, 'breakfast' => false],
                    ],
                    'checkout'  => [
                        ['min_in_hour'  => 0, 'max_in_hour' => 12, 'amount' => 0],
                        ['min_in_hour'  => 12, 'max_in_hour' => 16, 'amount' => 0],
                        ['min_in_hour'  => 16, 'max_in_hour' => 23, 'amount' => 80000],
                    ],
                    'cancellation'      => [
                        ['min_in_hour'  => 0, 'max_in_hour' => 1, 'percentage' => 100],
                        ['min_in_hour'  => 1, 'max_in_hour' => 2, 'percentage' => 50],
                    ],
                    'normal_rate'       => 450000,
                    'weekend_rate'      => 600000,
                    'ota_normal_rate'   => 500000,
                    'ota_weekend_rate'  => 685000,
                    'rate'      => [
                        ['min_occupancy_in_percentage' => 0, 'max_occupancy_in_percentage' => 50, 'increase_rate_in_percentage' => 0],
                        ['min_occupancy_in_percentage' => 51, 'max_occupancy_in_percentage' => 75, 'increase_rate_in_percentage' => 25],
                        ['min_occupancy_in_percentage' => 76, 'max_occupancy_in_percentage' => 100, 'increase_rate_in_percentage' => 50],
                    ],
                ],
                'fnb'           => [
                    'breakfast_start_in_hour'     => 6,
                    'breakfast_end_in_hour'       => 11,
                    'breakfast_normal_rate'       => 80000,
                    'breakfast_weekend_rate'      => 90000,
                ],
                'membership'    => [
                    'partner'   => [
                        ['min'  => 1000000000, 'max' => null, 'level' => 'platinum', 'gain_in_money' => 5000, 'log_in_money' => 100000],
                        ['min'  => 650000000, 'max' => 1000000000, 'level' => 'gold', 'gain_in_money' => 3000, 'log_in_money' => 100000],
                        ['min'  => null, 'max' => 650000000, 'level' => 'silver', 'gain_in_money' => 2000, 'log_in_money' => 100000],
                    ],
                    'guest'     => [
                        ['min'  => 25000000, 'max' => null, 'level' => 'platinum', 'gain_in_money' => 5000, 'log_in_money' => 100000],
                        ['min'  => 15000000, 'max' => 25000000, 'level' => 'gold', 'gain_in_money' => 3000, 'log_in_money' => 100000],
                        ['min'  => null, 'max' => 15000000, 'level' => 'silver', 'gain_in_money' => 2000, 'log_in_money' => 100000],
                    ],
                ],
                'tax'           => [
                    'service'   => 10,
                    'govern'    => 11,
                ],
                'tv_channel'    => [
                    ['no' => '001', 'name' => 'INDOSIAR', 'category' => 'HIBURAN'], 
                    ['no' => '002', 'name' => 'SCTV', 'category' => 'HIBURAN'], 
                    ['no' => '003', 'name' => 'MNC TV', 'category' => 'HIBURAN'], 
                    ['no' => '004', 'name' => 'ANTV', 'category' => 'OLAHRAGA'], 
                    ['no' => '005', 'name' => 'RCTI', 'category' => 'HIBURAN'], 
                    ['no' => '006', 'name' => 'METRO TV', 'category' => 'BERITA'],
                ]
			]
    	]);
    }
}
