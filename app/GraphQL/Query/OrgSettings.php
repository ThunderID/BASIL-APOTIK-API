<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use GraphQL;
use Auth;
use App\Org;
use App\OrgSetting;

class OrgSettings extends Query
{
    protected $attributes = [
        'name' => 'OrgSettings',
        'description' => 'A query'
    ];

    const LIMIT = 25;

    public function type()
    {
        return Type::listof(GraphQL::type('OrgSetting'));
    }

    public function authorize(array $args) : bool
    {
        return true;
    }

    public function args()
    {
        return [
            'org_id'    => ['type'  => Type::Int(), 'rules' => ['nullable']],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        if(isset($args['org_id'])){
            $org    = OrgSetting::where('org_id', $args['org_id'])->where('active_at', '<=', now())->orderby('active_at', 'desc')->first();
        }else{
            $org    = OrgSetting::where('active_at', '<=', now())->orderby('active_at', 'desc')->first();
        }

        return [$org];
    }
}