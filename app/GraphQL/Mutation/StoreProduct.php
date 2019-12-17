<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

use GraphQL;
use Auth;

use App\Org;
use App\Product;
use App\Models\Purchasing\Invoice;

use Thunderlabid\WMS\GRN;
use Thunderlabid\WMS\Warehouse;

class StoreProduct extends Mutation
{
    protected $attributes = [
        'name' => 'StoreProduct',
        'description' => 'Tambah produk baru'
    ];

    public function authorize(array $args) : bool
    {
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? Product::find($args['id']) : app()->make(Product::class)->fill($args)
                                );
    }

    public function type()
    {
        return GraphQL::type('Product');
    }

    public function args()
    {
        return [
            'id'           => ['type' => Type::Int()],
            'org_id'       => ['type' => Type::Int()],
            'code'         => ['type' => Type::String()],
            'name'         => ['type' => Type::String()],
            'group'        => ['type' => Type::String()],
            'description'  => ['type' => Type::String()],
            'unit'                  => ['type' => Type::string(), 'description' => 'such as gram, kg, pill, dst'],
            'threshold'             => ['type' => Type::Int(), 'description' => 'default will be 2'],
            'opening_stock'         => ['type' => Type::Int(), 'description' => 'only valid for new product'],
            'opening_cogs'          => ['type' => Type::Int(), 'description' => 'only valid for new product'],
        ];
    }

    public function rules(array $args = []) : array
    {
        return  [
            'id'           => ['nullable', 'exists:' . app()->make(Product::class)->getTable() . ',id'],
            'org_id'       => ['required', 'exists:' . app()->make(Org::class)->getTable() . ',id'],
            'name'         => ['required_without:id', 'string'],
            'code'         => ['required_without:id', 'string'],
            'group'        => ['required_without:id', 'string'],
            'description'  => ['nullable', 'string'],
            'threshold'     => ['nullable', 'numeric'],
            'opening_stock' => ['nullable', 'numeric'],
            'opening_cogs'  => ['nullable', 'numeric'],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        \DB::beginTransaction();

        $product = isset($args['id']) ? Product::find($args['id']) : new Product;
        $product->fill($args);
        $product->save();


        //SIMPAN INIT STOCK
        if((isset($args['opening_stock']) && $args['opening_stock'] > 0) && !isset($args['id'])){
            $lines  = [];
            $inv    = Invoice::issuedToday($product->created_at)->wherenull('partner_id')->first();
            if(!$inv){
                $inv= new Invoice;
            }
            $lines  = $inv->lines;
            $lines[]= ['product_id' => $product->id, 'qty' => $args['opening_stock'], 'price' => $args['opening_cogs'], 'discount' => 0];
            $inv->org_id    = $product->org_id;
            $inv->issued_at = $product->created_at;
            $inv->lines     = $lines;
            $inv->save();

            $wh     = Warehouse::where('org_id', $inv->org_id)->first();
            //SIMPAN DEFAULT GRN
            $lines  = [];
            $grn    = GRN::where('ref_id', $inv->id)->where('ref_type', get_class($inv))->first();
            if(!$grn){
                $grn= new GRN; 
            }
            $grn->date      = $inv->issued_at;
            $grn->ref_id    = $inv->id;
            $grn->ref_type  = get_class($inv);
            $grn->warehouse_id  = $wh->id;
            $lines[]= ['product_id' => $product->id, 'qty' => $args['opening_stock'], 'sku' => $product->code, 'name' => $product->name];
            $grn->lines     = $lines;
            $grn->save();
        }
        \DB::commit();

        return $product;
    }
}
