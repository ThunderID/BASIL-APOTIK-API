<?php

namespace App\GraphQL\Mutation\Purchasing;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;
use App\Models\Purchasing\Invoice;

class DeletePurchasingInvoice extends Mutation
{
    protected $attributes = [
        'name' => 'DeletePurchasingInvoice',
        'description' => 'Hapus produk'
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
            'id'        => ['required', 'exists:' . app()->make(Invoice::class)->getTable() . ',id'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $invoice = Invoice::findorfail($args['id']);
        $invoice->delete();

        return true;
    }
}