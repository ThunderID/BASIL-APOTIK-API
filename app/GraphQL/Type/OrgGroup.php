<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class OrgGroup extends GraphQLType
{
    protected $attributes = [
        'name'        => 'OrgGroup',
        'description' => 'A type',
        'model'       => \App\OrgGroup::class
    ];

    public function fields()
    {
        return [
            'id'    => ['type' => Type::int(), 'description' => ''],
            'name'  => ['type' => Type::string(), 'description' => ''],
          
            'orgs'  => ['type' => Type::listOf(GraphQL::type('Org')), 'description' => ''],
            'owner' => ['type' => GraphQL::type('User'), 'description' => ''],
        ];
    }
}