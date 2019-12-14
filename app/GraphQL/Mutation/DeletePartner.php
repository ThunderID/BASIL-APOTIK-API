<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\Partner;

class DeletePartner extends Mutation
{
    protected $attributes = [
        'name' => 'DeletePartner',
        'description' => 'A mutation'
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
            'id'        => ['required', 'exists:' . app()->make(Partner::class)->getTable() . ',id'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $partner = Partner::findorfail($args['id']);
        $partner->delete();

        return true;
    }
}