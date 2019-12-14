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

class Authenticate extends Mutation
{
    protected $attributes = [
        'name' => 'Authenticate',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return GraphQL::type('Login');
    }

    public function args()
    {
        return [
            'username' => ['type'  => Type::String(), 'description' => ''],
            'password' => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = User::authenticate($args['username'], $args['password']);
        if ($user)
        {
            $token = array(
                "iss" => config('jwt.JWT_ISS'),
                "aud" => config('jwt.JWT_AUD'),
                "iat" => now()->timestamp,
                "username" => $user->username
            );
            $jwt = JWT::encode($token, config('jwt.JWT_KEY'), config('jwt.JWT_ALGORITHM'));

            return [
                'token' => $jwt,
                'user'  => $user
            ];
        }
    }
}