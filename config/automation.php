<?php

return [
	'status' 	=> ['org_ids' => [1]],
	'rate'		=> [
		'org_ids' => [1], 
		// 'room_rate_table'  => [
		// 	1 =>['min' => 75, 'max' => 100, 'perc' => 20],
		// 		['min' => 50 , 'max' => 75, 'perc' => 20],
		// 		['min' => 0, 'max' => 50, 'perc' => 20],
		// ],
	],

	'membership'=> [
		'org_group_ids' => [1], 
		'partner_rate_table'  => [
			1 =>['min' => 1000000000, 'max' => null, 'level' => 'platinum'],
				['min' => 650000000 , 'max' => 1000000000, 'level' => 'gold'],
				['min' => null, 'max' => 650000000, 'level' => 'silver'],
		],
		'user_rate_table'  => [
			1 =>['min' => 25000000, 'max' => null, 'level' => 'platinum'],
				['min' => 15000000 , 'max' => 25000000, 'level' => 'gold'],
				['min' => null, 'max' => 15000000, 'level' => 'silver'],
		],
	],

	'tv_channel'	=> [
		['no' => '001', 'name' => 'INDOSIAR', 'category' => 'HIBURAN'], 
		['no' => '002', 'name' => 'SCTV', 'category' => 'HIBURAN'], 
		['no' => '003', 'name' => 'MNC TV', 'category' => 'HIBURAN'], 
		['no' => '004', 'name' => 'ANTV', 'category' => 'OLAHRAGA'], 
		['no' => '005', 'name' => 'RCTI', 'category' => 'HIBURAN'], 
		['no' => '006', 'name' => 'METRO TV', 'category' => 'BERITA'], 
	],
];