<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;
use App\OrgGroup;

class OrgGroups extends Query
{
    protected $attributes = [
        'name' => 'OrgGroups',
        'description' => 'A query'
    ];

    const LIMIT = 25;

    public function type()
    {
        return GraphQL::paginate('OrgGroup');
    }

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('view', new OrgGroup);
    }

    public function args()
    {
        return [
            'id'    => ['type'  => Type::Int()],
            'name'  => ['type'  => Type::String()],
            'city'  => ['type'  => Type::String()],
            'page'  => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
            'limit' => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $q = new OrgGroup;

        if ($with)
        {
            $q = $q->with($with);
        }

        foreach ($args as $k => $v)
        {
            switch ($k) 
            {
                case 'name': $q = $q->name($v); break;
            }
        }

        return $q->paginate(
            isset($args['limit']) ? $args['limit'] : Static::LIMIT,
            '*',
            'page',
            isset($args['page']) ? $args['page'] : 1
        );
    }
}