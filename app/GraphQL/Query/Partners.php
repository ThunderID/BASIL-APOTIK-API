<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;
use App\Partner;

class Partners extends Query
{
    protected $attributes = [
        'name' => 'Partners',
        'description' => 'A query'
    ];

    const LIMIT = 25;

    public function type()
    {
        return GraphQL::paginate('Partner');
    }

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('view', new Partner);
    }

    public function args()
    {
        return [
            'id'            => ['type'  => Type::Int()],
            'org_group_id'  => ['type'  => Type::Int()],
            'name'          => ['type'  => Type::String()],
            'city'          => ['type'  => Type::String()],
            'scopes'        => ['type'  => Type::listOf(Type::string())],
            'page'          => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
            'limit'         => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $q = new Partner;

        if ($with)
        {
            $q = $q->with($with);
        }

        foreach ($args as $k => $v)
        {
            switch ($k) 
            {
                case 'id':              $q = $q->where('id', $v); break;
                case 'org_group_id':    $q = $q->where('org_group_id', $v); break;
                case 'scopes':          $q = $q->Type($v); break;
                case 'name':            $q = $q->name($v); break;
                case 'city':            $q = $q->city($v); break;
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