<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Pricing\RoomType;
use Faker\Generator as Faker;

$factory->define(RoomType::class, function (Faker $faker) {
	$bed 	= rand(2,3);
	$bf 	= [0, $bed];
    return [
        //
        'name'        => 'RoomType',
        'description' => $faker->text(13),
        'facilities'  => ['room_capacity' => $bed, 'breakfast' => $bf[rand(0,1)]],
    ];
});
