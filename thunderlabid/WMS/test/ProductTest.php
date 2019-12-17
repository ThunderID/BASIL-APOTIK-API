<?php

namespace Thunderlabid\WMS\Test;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

use Thunderlabid\WMS\Warehouse;
use Thunderlabid\WMS\Product;
use Thunderlabid\WMS\Job\Warehouse\Store as StoreWarehouse;
use Thunderlabid\WMS\Job\Warehouse\Delete as DeleteWarehouse;

use Thunderlabid\WMS\Job\Product\Store as StoreProduct;
use Thunderlabid\WMS\Job\Product\Delete as DeleteProduct;
use Thunderlabid\WMS\Job\Product\Price\Add as AddPrice;
use Thunderlabid\WMS\Job\Product\Price\Delete as DeletePrice;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $warehouse_attr = [
        'name'           => 'WMS-A',
        'is_active'      => true,
    ];

    protected $product_attr = [
        'code'           => 'CODE-01',
        'name'           => 'Product-01',
        'is_available'   => true,
    ];

    public function testBasic()
    {
        /*----------  Prepare Warehouse  ----------*/
        $attr = $this->warehouse_attr;
        $WMS = StoreWarehouse::dispatchNow(null, $attr);

        $this->product_attr['warehouse_id'] = $WMS->id;

        /*----------  Basic  ----------*/
        $product_attr = $this->product_attr;

        $product = StoreProduct::dispatchNow(null, $product_attr);
        $this->assertNotNull($product->id);

        /*----------  Duplicate  ----------*/
        $product_attr = $this->product_attr;
        try {
            StoreProduct::dispatchNow(null, $product_attr);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('unique', $e->errors()['code']));
            $this->assertTrue(in_array('unique', $e->errors()['name']));
        }

        /*----------  Edit  ----------*/
        $product_attr['code'] = 'CODE-02';
        $product_attr['name'] = 'Product-02';
        $product = StoreProduct::dispatchNow($product->id, $product_attr);
        $this->assertTrue($product->code == $product_attr['code']);
        $this->assertTrue($product->name == $product_attr['name']);

        /*----------  Delete Basic  ----------*/
        $this->assertTrue(DeleteProduct::dispatchNow($product->id));

        /*----------  Delete If Product in StockCard  ----------*/


        /*----------  Delete If Product has price  ----------*/
        try {
            $product = StoreProduct::dispatchNow(null, $product_attr);
            $product->prices()->create([
                'active_at' => now(),
                'price'     => 50000,
                'discount'  => 0
            ]);
            DeleteProduct::dispatchNow($product->id);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('immutable:HAS_PRICES', $e->errors()['id']));
        }
        

    }
}
