<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Geolocation extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Geolocation',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'latitude'     => ['type' => Type::float(), 'description' => ''],
            'longitude'    => ['type' => Type::float(), 'description' => ''],
        ];
    }
}