<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\OrgGroup;

class StoreOrgGroup extends Mutation
{
    protected $attributes = [
        'name' => 'StoreOrgGroup',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? OrgGroup::find($args['id']) : app()->make(OrgGroup::class)->fill($args)
                                );
    }

    public function type()
    {
        return GraphQL::type('OrgGroup');
    }

    public function args()
    {
        return [
            'id'       => ['type'  => Type::int(), 'description' => ''],
            'name'     => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'       => ['nullable', 'exists:' . app()->make(OrgGroup::class)->getTable() . ',id'],
            'name'     => ['required_without:id', 'string'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $args['owner_id'] = Auth::id();
        $room = isset($args['id']) ? \App\OrgGroup::find($args['id']) : new OrgGroup;
        $room->fill($args);
        $room->save();

        return $room;
    }
}