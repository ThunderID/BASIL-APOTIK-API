<?php

namespace App\GraphQL\Mutation\Purchasing;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use DB;

use App\Product;
use App\Models\Purchasing\Invoice;

class StorePurchasingInvoice extends Mutation
{
    protected $attributes = [
        'name' => 'StorePurchasingInvoice',
        'description' => 'Tambah nota pembelian'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Invoice::find($args['id']) : app()->make(Invoice::class)->fill($args)
                                );
    }

    public function type()
    {
        return GraphQL::type('PurchasingInvoice');
    }

    public function args()
    {
        return [
            'id'            => ['type'  => Type::int(), 'description' => ''],
            'org_id'        => ['type'  => Type::int(), 'description' => ''],
            'partner_id'    => ['type'  => Type::int(), 'description' => 'partner id gained from query partners (as supplier)'],
            'issued_at'     => ['type'  => Type::string(), 'description' => ''],
            'lines'         => ['type'  => Type::listof(GraphQL::Type('IPurchasingInvoiceLine')), 'description' => ''],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'                => ['nullable', 'exists:' . app()->make(Invoice::class)->getTable() . ',id'],
            'org_id'            => ['required', 'exists:' . app()->make(\App\Org::class)->getTable() . ',id'],
            'partner_id'        => ['required', 'exists:' . app()->make(\App\Partner::class)->getTable() . ',id'],
            'issued_at'         => ['required', 'string'],
            'lines'             => ['required', 'array'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with   = $fields->getRelations();

        DB::beginTransaction();

        $dt     = isset($args['id']) ? Invoice::find($args['id']) : new Invoice;
        $dt->fill($args);
        $dt->save();
        
        DB::commit();

        return $dt;
    }
}
