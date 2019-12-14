<?php

use Illuminate\Database\Seeder;
use Illuminate\Validation\ValidationException;

use Thunderlabid\POS\POSPoint;
use Thunderlabid\POS\Product;
use Thunderlabid\POS\Price;
use \App\Models\Membership\MemberPoint;
class LaunchSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// $p = \App\Partner::orderby('created_at', 'desc')->first();
		// $p->pr_id = 1;
		// $p->save();
		// try {
			
		// 	foreach (range(0,20) as $k) {
		// 		$net 	= rand(100,999);

		// 		MemberPoint::create(['date' => now()->subdays($k), 'amount' => ($net*1000), 'net_revenue' => ($net*50000), 'partner_id' => $p->id, 'org_group_id' => $p->org_group_id, 'note' => 'Transaksi #000'.($k+1), 'ref_id' => 0, 'ref_type' => 'KONTENA']);
		// 	}
		// } catch (\Exception $e) {
		// 	dd($e->getMessage());
		// }
		// exit;
		
		try {
			$user 		= \App\User::create([
	        	'name'	=> "Erick Mo",
	        	'username' => '6281333517875',
	        	'password' => '123123123'
	        ]);


			$org_group = factory(\App\OrgGroup::class)->create([
				'owner_id'	=> $user->id,
				'name'      => 'KONTENA CHAIN HOTEL'
			]);

			$org = factory(\App\Org::class)->create([
				'org_group_id' => $org_group->id,
				'name'         => 'KONTENA BATU',
				'address'	   => 'Jl. Kh Agus Salim no 106',
				'city'	   	   => 'Batu',
				'province'	   => 'East Java',
				'country'	   => 'Indonesia',
				'geolocation'  => ['latitude' => -7.8820505, 'longitude' => 112.5271359]
			]);

			$role		= \App\UserRole::create(['user_id' => $user->id, 'org_id' => $org->id, 'role' => 'OWNER', 'scopes' => ['*']]);

			//ROOM TYPE
			$data 	= [
				['name' => 'KONTENA ROOM', 'is_partnership_program' => false, 'breakfast' => 0, 'single_bed' => 2, 'double_bed' => 0, 'room_capacity' => 3, 'price' => 550000],
				['name' => 'KONTENA ROOM + BREAKFAST', 'is_partnership_program' => false, 'breakfast' => 2, 'single_bed' => 2, 'double_bed' => 0, 'room_capacity' => 3, 'price' => 700000],

				// ['name' => 'KONTENA ROOM FOR TRAVEL AGENT', 'is_partnership_program' => true, 'breakfast' => 0, 'single_bed' => 2, 'double_bed' => 0, 'room_capacity' => 3, 'price' => 500000],
				// ['name' => 'KONTENA ROOM + BREAKFAST FOR TRAVEL AGENT', 'is_partnership_program' => true, 'breakfast' => 2, 'single_bed' => 2, 'double_bed' => 0, 'room_capacity' => 3, 'price' => 1000000],
			];

			foreach ($data as $i => $v) {
				$room_types[$i] 	= factory(\App\Models\Pricing\RoomType::class)->create([
					'org_id' 	=> $org->id, 
					'name' 		=> $v['name'],
					'facilities'=> ['room_capacity' => $v['room_capacity'], 'breakfast' => $v['breakfast'], 'double_bed' => $v['double_bed'], 'single_bed' => $v['single_bed']],
					'gallery'	=> ['default' => 'https://basilhotel.sgp1.digitaloceanspaces.com/kontena/attendance/2019/12/13/HOTELROOM.jpg']
				]);

				$room_rates[$i] = \App\Models\Pricing\RoomRate::create([
					'room_type_id' 	=> $room_types[$i]->id, 
					'price' 		=> $v['price'],
					'discount' 		=> 0,
					'started_at'	=> now()->addminutes(2),
				]);
			}

			for ($i = 1101; $i <= 1137; $i++)
			{
				$room = factory(\App\Room::class)->create([
					'org_id'       => $org->id,
					'name'         => str_pad($i, 4, '0', STR_PAD_LEFT)
				]);

				$status = \App\Models\HK\RoomStatus::create([
					'user_id' 		=> $user->id, 
					'room_id' 		=> $room->id, 
					'status' 		=> \App\Models\HK\RoomStatus::VACANT_READY,
					'due_to_next_status'	=> now()->endofday(),
				]);
			}

			for ($i = 2101; $i <= 2137; $i++)
			{
				$room = factory(\App\Room::class)->create([
					'org_id'       => $org->id,
					'name'         => str_pad($i, 4, '0', STR_PAD_LEFT)
				]);

				$status = \App\Models\HK\RoomStatus::create([
					'user_id' 		=> $user->id, 
					'room_id' 		=> $room->id, 
					'status' 		=> \App\Models\HK\RoomStatus::VACANT_READY,
					'due_to_next_status'	=> now()->endofday(),
				]);
			}

			$rooms 	= \App\Room::where('org_id', $org['id'])->get();

			foreach ($room_types as $k => $v) 
			{
				foreach ($rooms as $room) {
					$v->rooms()->attach($room->id);
				}
			}

			//RESTO
			$pos = POSPoint::create(['org_id' => $org['id'],'name' => 'SHOKUDO RESTAURANT', 'category' => 'RESTAURANT', 'is_active' => true]);

			if (($handle = fopen('http://128.199.145.173:9888/2019/12/12/shokudo_menu.csv', 'r')) !== FALSE) 
			{
				$header         = null;

				while (($data = fgetcsv($handle, 500, ",")) !== FALSE) 
				{
					if ($header === null) 
					{
						$header = $data;
						continue;
					}
				
					$all_row    = array_combine($header, $data);
					try {
						if(empty($all_row['code'])){
							// \Log::info($all_row['no']);
							break;
						}
						\DB::beginTransaction();
							$prod 		= Product::where('code', $all_row['code'])->first();
							if(!$prod){
								$prod   = new Product;
							}
							$prod->fill(['pos_point_id' => $pos['id'], 'group' => $all_row['group'], 'name' => $all_row['name'], 'code' => $all_row['code'], 'description' => $all_row['description'], 'is_available' => true]);
							$prod->save();

							$price 	= Price::create(['product_id' => $prod->id, 'active_at' => now()->addminutes(2), 'price' => $all_row['price'], 'discount' => 0]);
						\DB::commit();
					}catch(\Exception $e){
						dd($e);
					}
				}
			}

			/**
			//ARTIKEL
			if (($handle = fopen('http://128.199.145.173:9888/2019/12/12/kontena_article.csv', 'r')) !== FALSE) 
			{
				$header         = null;

				while (($data = fgetcsv($handle, 500, ",")) !== FALSE) 
				{
					if ($header === null) 
					{
						$header = $data;
						continue;
					}
				
					$all_row    = array_combine($header, $data);
					try {
						if(empty($all_row['code'])){
							// \Log::info($all_row['no']);
							break;
						}
						\DB::beginTransaction();
							$prod 		= \App\Product::where('code', $all_row['code'])->first();
							if(!$prod){
								$prod   = new Product;
							}
							$product = \App\Product::create(['org_id' => $org['id'], 'name' => $all_row['name'], 'code' => $all_row['code'], 'group' => $all_row['group'], 'is_amenity' => false, 'is_additional_service' => false]);
						\DB::commit();
					}catch(\Exception $e){
						dd($e);
					}
				}
			} **/

			//ACCESS
			$org 	= \App\Org::first();
			if (($handle = fopen('http://128.199.145.173:9888/2019/12/12/kontena_tim.csv', 'r')) !== FALSE) 
			{
				$header         = null;

				while (($data = fgetcsv($handle, 500, ",")) !== FALSE) 
				{
					if ($header === null) 
					{
						$header = $data;
						continue;
					}
				
					$all_row    = array_combine($header, $data);
					try {
						if(empty($all_row['username'])){
							// \Log::info($all_row['no']);
							break;
						}
						\DB::beginTransaction();

							$scopes = \App\UserRole::SCOPES;
							$roles	= \App\UserRole::ROLES;

							$user   = \App\User::where('username', $all_row['username'])->first();
							if(!$user){
								$user 		= new \App\User;
							}
							$user->fill([
					        	'name'	=> $all_row['name'],
					        	'username' => $all_row['username'],
					        	'password' => 'timkontena!'
					        ]);
					        $user->save();

							$role 	= \App\UserRole::create(['user_id' => $user->id, 'org_id' => $org->id, 'role' => $all_row['role'], 'scopes' => $scopes[$all_row['role']], 'photo_url' => $all_row['photo_url']]);

						\DB::commit();
					}catch(\Exception $e){
						dd($all_row);
						dd($e->getMessage());
					}
				}
			}
		}
		catch (ValidationException $e) {
			dd($e->errors());
		} 
	}
}
