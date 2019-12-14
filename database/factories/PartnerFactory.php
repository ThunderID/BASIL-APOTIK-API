<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Partner;
use Faker\Generator as Faker;

$factory->define(Partner::class, function (Faker $faker) {
	$scopes 	= [['COMPANY'], ['TRAVEL_AGENT', 'OTA'], ['COMPANY', 'TRAVEL_AGENT', 'OTA']];
	return [
		'name'     => $faker->name,
		'address'  => $faker->address,
		'city'     => $faker->city,
		'province' => $faker->state,
		'country'  => $faker->country,
		'phone'    => $faker->phoneNumber,
		'scopes'   => $scopes[rand(0,2)],
	];
});
