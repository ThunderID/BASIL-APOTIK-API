<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\OrgSetting;

class StoreOrgSetting extends Mutation
{
    protected $attributes = [
        'name' => 'StoreOrgSetting',
        'description' => 'A mutation'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can('create', app()->make(OrgSetting::class)->fill($args));
    }

    public function type()
    {
        return GraphQL::type('OrgSetting');
    }

    public function args()
    {
        return [
            'org_id'        => ['type'  => Type::Int(), 'description' => ''],
            // 'hotel_setting' => ['type'  => GraphQL::type('IHotelSetting'), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'org_id'        => ['required'],
            'hotel_setting' => ['required', 'array'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $set                = new OrgSetting;
        $set->org_id        = $args['org_id'];
        $set->setting       = $args['hotel_setting'];
        $set->active_at     = now();
        $set->save();

        return $set;
    }
}