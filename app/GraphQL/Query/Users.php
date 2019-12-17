<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;
use App\User;
use Carbon\Carbon;

class Users extends Query
{
    protected $attributes = [
        'name' => 'Users',
        'description' => 'A query'
    ];

    const LIMIT = 25;

    public function type()
    {
        return GraphQL::paginate('User');
    }

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('view', new User);
    }

    public function args()
    {
        return [
            'id'    => ['type'  => Type::Int()],
            'name'  => ['type'  => Type::String()],
            'email'     => ['type'  => Type::String()],
            'username'  => ['type'  => Type::String()],
            'page'  => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
            'limit' => ['type'  => Type::Int(), 'rules' => ['integer', 'gte:1']],
            'in_house_at'       => ['type'  => Type::string()],
            'has_reception_in'  => ['type'  => Type::listof(Type::int())],
            'created_at_lt'   => ['type'  => Type::String()],
            'created_at_lte'  => ['type'  => Type::String()],
            'created_at_gt'   => ['type'  => Type::String()],
            'created_at_gte'  => ['type'  => Type::String()],
            'updated_at_lt'   => ['type'  => Type::String()],
            'updated_at_lte'  => ['type'  => Type::String()],
            'updated_at_gt'   => ['type'  => Type::String()],
            'updated_at_gte'  => ['type'  => Type::String()],
            'order_desc'      => ['type'  => Type::boolean()],
            'order_by'        => ['type'  => Type::String()],
            'is_guest'        => ['type'  => Type::boolean()],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        $desc   = 'desc';

        $q = new User;

        if ($with)
        {
            $q = $q->with($with);
        }

        foreach ($args as $k => $v)
        {
            switch ($k) 
            {
                case 'id':   $q         = $q->where('id', $v); break;
                case 'name':   $q       = $q->where('name', 'like', '%'.$v.'%'); break;
                case 'username': $q     = $q->username($v); break;
                case 'email':   $q      = $q->where('email', 'like', $v); break;
                case 'is_guest': 
                    if($v){
                        $q              = $q->where(function($q){
                            $q->wherehas('stays', function($q){$q;})->orwherehas('receptions', function($q){$q;});
                        });
                    }elseif($v){
                        $q              = $q->where(function($q){
                            $q->wheredoesnthave('stays', function($q){$q;})->wheredoesnthave('receptions', function($q){$q;});
                        });
                    }
                break;
                case 'in_house_at':
                    $v = Carbon::parse($v);
                    $q = $q->where(function($q2)use($v){
                        $q2->wherehas('stays.reception_line.reception', function($q3)use($v){$q3->InHouseAt($v);})
                        ->orwherehas('receptions', function($q3)use($v){$q3->InHouseAt($v);})
                        ;
                    })->where(function($q2)use($v){
                        $q2->wherehas('stays.reception_line.reception.lines', function($q3)use($v){$q3->wherenotnull('ci_at')->wherenull('co_at');})
                        ->orwherehas('receptions.lines', function($q3)use($v){$q3->wherenotnull('ci_at')->wherenull('co_at');})
                        ;
                    })->with([
                        'stays.reception_line.reception' => function($q3)use($v){$q3->InHouseAt($v);},
                        'stays.reception_line.reception.lines' => function($q3)use($v){$q3->wherenotnull('ci_at')->wherenull('co_at');},
                        'receptions' => function($q3)use($v){$q3->InHouseAt($v);},
                        'receptions.lines' => function($q3)use($v){$q3->wherenotnull('ci_at')->wherenull('co_at');},
                    ]); 
                break;
                case 'has_reception_in':
                    $q = $q->where(function($q2)use($v){
                        $q2->wherehas('stays.reception_line.reception', function($q3)use($v){$q3->whereIn('org_id', $v);})
                        ->orwherehas('receptions', function($q3)use($v){$q3->whereIn('org_id', $v);})
                        ;
                    }); 
                break;
                case 'created_at_lt':  $q = $q->where('created_at', '<', $v); break;
                case 'created_at_lte': $q = $q->where('created_at', '<=', $v); break;
                case 'created_at_gt':  $q = $q->where('created_at', '>', $v); break;
                case 'created_at_gte': $q = $q->where('created_at', '>=', $v); break;
                case 'updated_at_lt':  $q = $q->where('updated_at', '<', $v); break;
                case 'updated_at_lte': $q = $q->where('updated_at', '<=', $v); break;
                case 'updated_at_gt':  $q = $q->where('updated_at', '>', $v); break;
                case 'updated_at_gte': $q = $q->where('updated_at', '>=', $v); break;
                case 'order_desc':   
                    if(!$v){
                        $desc   = 'asc'; 
                    }
                break;
                case 'order_by':       $q = $q->orderby($v, $desc); break;
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