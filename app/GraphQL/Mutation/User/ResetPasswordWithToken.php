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
use App\UserToken;

class ResetPasswordWithToken extends Mutation
{
    protected $attributes = [
        'name' => 'ResetPasswordWithToken',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return [
            'username' => ['type'  => Type::String(), 'description' => ''],
            'token'    => ['type'  => Type::String(), 'description' => ''],
            'password' => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'username' => ['required', 'string'],
            'token'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = User::username($args['username'])->first();
        return $user->resetPasswordWithToken($args['token'], $args['password']);
    }
}