<?php

namespace App\GraphQL\Mutation\User;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use Firebase\JWT\JWT;
use App\User;

class Register extends Mutation
{
    protected $attributes = [
        'name' => 'Register',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'name'     => ['type'  => Type::String(), 'description' => ''],
            'email'    => ['type'  => Type::String(), 'description' => ''],
            'username' => ['type'  => Type::String(), 'description' => ''],
            'password' => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'name'     => ['required', 'string'],
            'email'    => ['nullable', 'email'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = User::create($args);
        return $user;
    }
}