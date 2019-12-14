<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\UserRole;

class DeleteUserRole extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteUserRole',
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
        return Type::boolean();
    }

    public function args()
    {
        return [
            'id'            => ['type'  => Type::int(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'        => ['required', 'exists:' . app()->make(UserRole::class)->getTable() . ',id'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $role = UserRole::findorfail($args['id']);
        $role->delete();

        return true;
    }
}