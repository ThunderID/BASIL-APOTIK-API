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

class UpdateMyProfile extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateMyProfile',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function authorize(array $args) : bool
    {
        return !is_null(Auth::id());
    }

    public function args()
    {
        return [
            'name'     => ['type'  => Type::String(), 'description' => ''],
            'email'    => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'name'     => ['nullable', 'string'],
            'email'    => ['nullable', 'email'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = Auth::user();
        $user->fill($args);
        $user->save();

        return $user;
    }
}