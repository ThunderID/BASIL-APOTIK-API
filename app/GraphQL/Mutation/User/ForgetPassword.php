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

class ForgetPassword extends Mutation
{
    protected $attributes = [
        'name' => 'ForgetPassword',
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
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'username' => ['required', 'string'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = User::username($args['username'])->firstorfail();
        return $user->createResetPasswordToken();
    }
}