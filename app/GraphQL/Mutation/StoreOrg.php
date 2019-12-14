<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\Org;

class StoreOrg extends Mutation
{
    protected $attributes = [
        'name' => 'StoreOrg',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Org::find($args['id']) : app()->make(Org::class)->fill($args)
                                );
    }

    public function type()
    {
        return GraphQL::type('Org');
    }

    public function args()
    {
        return [
            'id'           => ['type'  => Type::Int(), 'description' => ''],
            'org_group_id' => ['type'  => Type::Int(), 'description' => ''],
            'name'         => ['type'  => Type::String(), 'description' => ''],
            'address'      => ['type'  => Type::String(), 'description' => ''],
            'city'         => ['type'  => Type::String(), 'description' => ''],
            'province'     => ['type'  => Type::String(), 'description' => ''],
            'country'      => ['type'  => Type::String(), 'description' => ''],
            'phone'        => ['type'  => Type::String(), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'           => ['nullable', 'exists:' . app()->make(Org::class)->getTable() . ',id'],
            'org_group_id' => ['nullable'],
            'name'         => ['required_without:id', 'string'],
            'address'      => ['required_without:id', 'string'],
            'city'         => ['required_without:id', 'string'],
            'province'     => ['required_without:id', 'string'],
            'country'      => ['required_without:id', 'string'],
            'phone'        => ['required_without:id', 'string'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $args['owner_id'] = Auth::id();
        $org = isset($args['id']) ? Org::find($args['id']) : new Org;
        $org->fill($args);
        $org->save();

        return $org;
    }
}