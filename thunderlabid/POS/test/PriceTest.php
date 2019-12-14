<?php

namespace Thunderlabid\POS\Test;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

use Thunderlabid\POS\POSPoint;
use Thunderlabid\POS\Product;
use Thunderlabid\POS\Job\POSPoint\Store as StorePOSPoint;
use Thunderlabid\POS\Job\POSPoint\Delete as DeletePOSPoint;

use Thunderlabid\POS\Job\Product\Store as StoreProduct;
use Thunderlabid\POS\Job\Product\Delete as DeleteProduct;
use Thunderlabid\POS\Job\Product\Price\Add as AddPrice;
use Thunderlabid\POS\Job\Product\Price\Delete as DeletePrice;

class PriceTest extends TestCase
{
    use RefreshDatabase;

    protected $pos_point_attr = [
        'name'           => 'POS-A',
        'is_active'      => true,
    ];

    protected $product_attr = [
        'code'           => 'CODE-01',
        'name'           => 'Product-01',
        'is_available'   => true,
    ];

    public function testBasic()
    {
        /*----------  Prepare POSPoint  ----------*/
        $attr = $this->pos_point_attr;
        $pos = StorePOSPoint::dispatchNow(null, $attr);

        $this->product_attr['pos_point_id'] = $pos->id;

        /*----------  Basic  ----------*/
        $product_attr = $this->product_attr;

        $product = StoreProduct::dispatchNow(null, $product_attr);
        $this->assertNotNull($product->id);

        /*----------  Add Price Basic  ----------*/
        $price = AddPrice::dispatchNow($product->id, [
            'active_at' => now(),
            'price'     => 50000,
            'discount'  => 0
        ]);

        /*----------  Add Price Invalid  ----------*/
        try {
            AddPrice::dispatchNow($product->id, [
                'active_at' => now()->subDay(),
                'price'     => 50000,
                'discount'  => 60000
            ]);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('after_or_equal:now', $e->errors()['active_at']));
            $this->assertTrue(in_array('lte_numeric:50000', $e->errors()['discount']));
        }

        /*----------  Add Price Future  ----------*/
        $future_price = AddPrice::dispatchNow($product->id, [
            'active_at' => now()->addDay(),
            'price'     => 50000,
            'discount'  => 10000
        ]);

        /*----------  Delete Price  ----------*/
        $this->assertTrue(DeletePrice::dispatchNow($product->id, $future_price->id));

        /*----------  Delete Price In The Past  ----------*/
        try {
            $this->assertTrue(DeletePrice::dispatchNow($product->id, $price->id));
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('immutable:PRICE_IN_PAST', $e->errors()['id']));
        }
    }
}
