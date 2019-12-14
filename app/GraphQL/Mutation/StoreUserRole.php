<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;

use App\User;
use App\Org;
use App\UserRole;

class StoreUserRole extends Mutation
{
    protected $attributes = [
        'name' => 'StoreUserRole',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? UserRole::find($args['id']) : app()->make(UserRole::class)->fill($args)
                                );
    }

    public function type()
    {
        return GraphQL::type('Role');
    }

    public function args()
    {
        return [
            'id'           => ['type'  => Type::Int(), 'description' => ''],
            'org_id'       => ['type'  => Type::Int(), 'description' => ''],
            'user_id'      => ['type'  => Type::Int(), 'description' => ''],
            'role'         => ['type'  => Type::String(), 'description' => 'in:'.implode(',', UserRole::ROLES)],
            'photo_url'    => ['type'  => Type::string(), 'description' => ''],
            'ended_at'     => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'           => ['nullable', 'exists:' . app()->make(UserRole::class)->getTable() . ',id'],
            'org_id'       => ['required', 'exists:' . app()->make(Org::class)->getTable() . ',id'],
            'user_id'      => ['required', 'exists:' . app()->make(User::class)->getTable() . ',id'],
            'role'         => ['required_without:id', 'string', 'in:'.implode(',', UserRole::ROLES)],
            'photo_url'    => ['nullable', 'string'],
            'ended_at'     => ['nullable', 'date'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $role = isset($args['id']) ? UserRole::find($args['id']) : new UserRole;

        $role->fill($args);
        $role->scopes   = UserRole::SCOPES[$role->role];
        $role->save();

        return $role;
    }
}