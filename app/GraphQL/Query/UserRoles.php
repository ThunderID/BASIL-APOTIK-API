<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;

use App\UserRole;

class UserRoles extends Query
{
    protected $attributes = [
        'name' => 'UserRoles',
        'description' => 'A query'
    ];

    const LIMIT = 25;

    public function type()
    {
        return GraphQL::paginate('Role');
    }

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('view', new UserRole);
    }

    public function args()
    {
        return [
            'id'            => ['type'  => Type::Int()],
            'user_id'       => ['type'  => Type::Int()],
            'org_id'        => ['type'  => Type::Int()],
            'name'          => ['type'  => Type::String()],
            'role'          => ['type'  => Type::String()],
            'has_ended'     => ['type'  => Type::boolean()],
            'page'          => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
            'limit'         => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $q = new UserRole;

        if ($with)
        {
            $q = $q->with($with);
        }

        foreach ($args as $k => $v)
        {
            switch ($k) 
            {
                case 'id':              $q = $q->where('id', $v); break;
                case 'user_id':         $q = $q->where('user_id', $v); break;
                case 'org_id':          $q = $q->where('org_id', $v); break;
                case 'role':            $q = $q->where('role', $v); break;
                case 'name':            $q = $q->wherehas('user', function($q)use($v){$q->name($v);}); break;
                case 'has_ended':   
                    if($v){
                        $q = $q->wherenotnull('ended_at');
                    }else{
                        $q = $q->wherenull('ended_at');
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