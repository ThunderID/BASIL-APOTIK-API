<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\OrgGroup;
use Faker\Generator as Faker;

$factory->define(OrgGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->name
        //
    ];
});
