<?php

use Illuminate\Database\Seeder;
use Illuminate\Validation\ValidationException;

class TestSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\User::truncate();
		\App\OrgGroup::truncate();
		\App\Org::truncate();

		try {

			$user 		= \App\User::create([
	        	'name'	=> "Erick Mo",
	        	'username' => '6281333517875',
	        	'password' => '123123123'
	        ]);


			$org_group = factory(\App\OrgGroup::class)->create([
				'owner_id'	=> $user->id,
				'name'      => 'PELITA GROUP'
			]);

			$org = factory(\App\Org::class)->create([
				'org_group_id' => $org_group->id,
				'name'         => 'PELITA SARI',
				'address'	   => 'Jl. Kh Agus Salim no 106',
				'city'	   	   => 'Batu',
				'province'	   => 'East Java',
				'country'	   => 'Indonesia',
				'geolocation'  => ['latitude' => -7.8820505, 'longitude' => 112.5271359]
			]);


		} catch (ValidationException $e) {
			dd($e->errors());
		}

	}
}
