<?php

namespace Thunderlabid\Cashier\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;
use Thunderlabid\Cashier\CashierSession;

class CashierSessions extends Query
{
    protected $attributes = [
        'name' => 'CashierSessions',
        'description' => 'A query'
    ];

    const LIMIT = 25;

    public function type()
    {
        return GraphQL::paginate('CashierSession');
    }

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('view', new CashierSession);
    }

    public function args()
    {
        return [
            'id'        => ['type'  => Type::Int()],
            'org_id'    => ['type'  => Type::Int()],
            'user_id'   => ['type'  => Type::Int()],
            'opened_at_lt'      => ['type'  => Type::String()],
            'opened_at_lte'     => ['type'  => Type::String()],
            'opened_at_gt'      => ['type'  => Type::String()],
            'opened_at_gte'     => ['type'  => Type::String()],
            'opened_at'         => ['type'  => Type::String()],
            'has_closed'        => ['type'  => Type::boolean()],
            'page'  => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
            'limit' => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $q = new CashierSession;

        if ($with)
        {
            $q = $q->with($with);
        }

        foreach ($args as $k => $v)
        {
            switch ($k) 
            {
                case 'org_id': $q = $q->where('org_id', $v); break;
                case 'user_id': $q = $q->where('user_id', $v); break;
                case 'issued_at_lt':  $q = $q->where('issued_at', '<', $v); break;
                case 'opened_at_lte': $q = $q->where('opened_at', '<=', $v); break;
                case 'opened_at_gt':  $q = $q->where('opened_at', '>', $v); break;
                case 'opened_at_gte': $q = $q->where('opened_at', '>=', $v); break;
                case 'opened_at':     $q = $q->where('opened_at', $v); break;
                case 'has_closed':   
                    if($v){
                        $q = $q->wherenotnull('closed_at'); 
                    }else{
                        $q = $q->wherenull('closed_at'); 
                    }
                break;
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