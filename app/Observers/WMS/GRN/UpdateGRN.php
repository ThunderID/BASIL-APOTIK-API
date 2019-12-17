<?php

namespace App\Observers\WMS\GRN;

use Illuminate\Validation\ValidationException;
use DB;

use \App\Product;
use \App\Models\Purchasing\Invoice;

use \Thunderlabid\WMS\GRN;
use \Thunderlabid\WMS\Warehouse;

class UpdateGRN
{
    //
    public function saved(Invoice $inv)
    {
    	$lines  = [];
        foreach ($inv->lines as $v) {
            $product    = Product::where('org_id', $inv->org_id)->where('id', $v['product_id'])->firstorfail();
            $lines[]    = ['product_id' => $product->id, 'qty' => $v['qty'], 'sku' => $product->code, 'name' => $product->name];
        }

        //REWRITE GDN
        $wh     = Warehouse::where('org_id', $inv->org_id)->first();
        $grn    = GRN::where('ref_id', $inv->id)->where('ref_type', get_class($inv))->first();
        if(!$grn){
            $grn= new GRN; 
        }
        $grn->date      = $inv->issued_at;
        $grn->ref_id    = $inv->id;
        $grn->ref_type  = get_class($inv);
        $grn->warehouse_id  = $wh->id;
        $grn->lines     = $lines;
        $grn->save();
    }

    public function deleting(Invoice $inv)
    {
        $grn    = GRN::where('ref_id', $inv->id)->where('ref_type', get_class($inv))->delete();
    }
}
