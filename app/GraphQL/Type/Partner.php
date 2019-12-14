<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Partner extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Partner',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id'       => ['type' => Type::int(), 'description' => ''],
            'org_id'   => ['type' => Type::int(), 'description' => ''],
            'pr_id'    => ['type' => Type::int(), 'description' => ''],
            'name'     => ['type' => Type::string(), 'description' => ''],
            'address'  => ['type' => Type::string(), 'description' => ''],
            'city'     => ['type' => Type::string(), 'description' => ''],
            'province' => ['type' => Type::string(), 'description' => ''],
            'country'  => ['type' => Type::string(), 'description' => ''],
            'phone'    => ['type' => Type::string(), 'description' => ''],
            'scopes'   => ['type' => Type::listof(Type::string()), 'description' => 'in : '.implode('/', \App\Partner::SCOPES)],
            'pr'            => ['type' => GraphQL::Type('User'), 'description' => ''],
            
            'org'      => ['type' => GraphQL::type('OrgGroup'), 'description' => ''],

        ];
    }
}