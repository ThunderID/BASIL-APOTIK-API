<?php

namespace App\GraphQL\Mutation\User;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use Illuminate\Validation\ValidationException;

use GraphQL;
use Auth;
use Firebase\JWT\JWT;
use App\User;

class UpdateMyPassword extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateMyPassword',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return Type::boolean();
    }

    public function authorize(array $args) : bool
    {
        return !is_null(Auth::id());
    }

    public function args()
    {
        return [
            'old_password' => ['type'  => Type::String(), 'description' => ''],
            'new_password' => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $user = Auth::user();
        if ($user->checkPassword($args['old_password']))
        {
            $user->password = $args['new_password'];
            $user->save();

            return true;
        }
        else
        {
            throw ValidationException::withMessages(['old_password' => 'invalid']);
        }
    }
}