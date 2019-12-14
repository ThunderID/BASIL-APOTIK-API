<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\User;
use App\Partner;
use App\Org;

class StorePartner extends Mutation
{
    protected $attributes = [
        'name' => 'StorePartner',
        'description' => 'Tambah supplier'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Partner::find($args['id']) : app()->make(Partner::class)->fill($args)
                                );
    }

    public function type()
    {
        return GraphQL::type('Partner');
    }

    public function args()
    {
        return [
            'id'           => ['type'  => Type::Int(), 'description' => ''],
            'org_id'       => ['type'  => Type::Int(), 'description' => ''],
            'pr_id'        => ['type'  => Type::Int(), 'description' => ''],
            'name'         => ['type'  => Type::String(), 'description' => ''],
            'address'      => ['type'  => Type::String(), 'description' => ''],
            'city'         => ['type'  => Type::String(), 'description' => ''],
            'province'     => ['type'  => Type::String(), 'description' => ''],
            'country'      => ['type'  => Type::String(), 'description' => ''],
            'phone'        => ['type'  => Type::String(), 'description' => ''],
            'scopes'       => ['type'  => Type::listOf(Type::string()), 'description' => 'in:'.implode('/', Partner::SCOPES)],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'           => ['nullable', 'exists:' . app()->make(Partner::class)->getTable() . ',id'],
            'org_id'       => ['required', 'exists:' . app()->make(Org::class)->getTable() . ',id'],
            'pr_id'        => ['nullable', 'exists:' . app()->make(User::class)->getTable() . ',id'],
            'name'         => ['required_without:id', 'string'],
            'address'      => ['required_without:id', 'string'],
            'city'         => ['required_without:id', 'string'],
            'province'     => ['required_without:id', 'string'],
            'country'      => ['required_without:id', 'string'],
            'phone'        => ['required_without:id', 'string'],
            'scopes'       => ['required_without:id', 'array'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $partner = isset($args['id']) ? Partner::find($args['id']) : new Partner;
        $partner->fill($args);
        $partner->save();

        return $partner;
    }
}