<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Role extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Role',
        'description' => 'A type',
    ];

    public function fields()
    {
        return [
            'id'        => ['type' => Type::int(),   'description' => ''],
            'org_id'    => ['type' => Type::int(),   'description' => ''],
            'user_id'   => ['type' => Type::int(),   'description' => ''],
            'role'      => ['type' => Type::String(), 'description' => ''],
            'scopes'    => ['type' => Type::listof(Type::String()), 'description' => ''],
            'ended_at'  => ['type' => Type::String(), 'description' => ''],
            'photo_url' => ['type' => Type::String(), 'description' => ''],
            'created_at'=> ['type' => Type::String(), 'description' => ''],
            'updated_at'=> ['type' => Type::String(), 'description' => ''],
            'org'       => ['type' => GraphQL::type('Org'), 'description' => ''],
            'user'      => ['type' => GraphQL::type('User'), 'description' => ''],
        ];
    }
}
