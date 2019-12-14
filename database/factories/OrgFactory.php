<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Org;
use Faker\Generator as Faker;

$factory->define(Org::class, function (Faker $faker) {
	return [
		'name'     => $faker->name,
		'address'  => $faker->address,
		'city'     => $faker->city,
		'province' => $faker->state,
		'country'  => $faker->country,
		'phone'    => $faker->phoneNumber,
	];
});
