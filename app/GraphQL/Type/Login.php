<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use GraphQL;
use Auth;

class Login extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Login',
        'description' => 'A type',
    ];

    public function fields()
    {
        return [
        	'token' => ['type' => Type::String(), 'description' => ''],
        	'user'  => ['type' => GraphQL::Type('User'), 'description' => ''],
        ];
    }
}