<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Bio extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Bio',
        'description' => 'A type',
        'model'       => \App\Bio::class
    ];

    public function fields()
    {
        return [
            'user_id'      => ['type' => Type::int(),   'description' => ''],
        	'name'         => ['type' => Type::String(), 'description' => ''],
        	'phone'        => ['type' => Type::String(), 'description' => ''],
        	'birthdate'    => ['type' => Type::String(), 'description' => ''],
            'pin'          => ['type' => Type::String(), 'description' => ''],
            'title'        => ['type' => Type::String(), 'description' => ''],
            'passport'     => ['type' => Type::String(),   'description' => ''],
            'address'      => ['type' => Type::String(), 'description' => ''],
        ];
    }
}
