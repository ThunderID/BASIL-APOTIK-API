<?php

namespace Thunderlabid\WMS\Test;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

use Thunderlabid\WMS\Warehouse;
use Thunderlabid\WMS\StockCard;
use Thunderlabid\WMS\Product;
use Thunderlabid\WMS\Settlement;
use Thunderlabid\WMS\Job\Warehouse\Store as StoreWarehouse;
use Thunderlabid\WMS\Job\Warehouse\Delete as DeleteWarehouse;

use Thunderlabid\WMS\Job\Product\Store as StoreProduct;
use Thunderlabid\WMS\Job\Product\Delete as DeleteProduct;

use Thunderlabid\WMS\Job\StockCard\Store as StoreStockCard;
use Thunderlabid\WMS\Job\StockCard\Delete as DeleteStockCard;
use Thunderlabid\WMS\Job\StockCard\Cancel as CancelStockCard;
use Thunderlabid\WMS\Job\Product\Price\Add as AddPrice;
use Thunderlabid\WMS\Job\Product\Price\Delete as DeletePrice;

use Arr;

class StockCardTest extends TestCase
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

    protected $stock_card = [
        'no'           => 'INV-01',
        'customer'     => 'Cust-01',
        'discount'     => 0,
        'tax'          => 0,
        'lines'         => [
            [
                'product_id' => 1,
                'code'       => '0001', 
                'name'       => 'PR-01', 
                'qty'        => 5, 
                'price'      => 25000,
                'discount'   => 0
            ],
        ],
    ];

    public function testBasic()
    {
        /*----------  Prepare  ----------*/
        $attr = $this->warehouse_attr;
        $WMS = StoreWarehouse::dispatchNow(null, $attr);

        try {
            $product_attr1 = $this->product_attr;
            $product_attr1['warehouse_id'] = $WMS->id;
            $product1 = StoreProduct::dispatchNow(null, $product_attr1);
            $product1->prices()->create([
                'active_at' => now(),
                'price'     => 50000,
                'discount'  => 0
            ]);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        try {
            $product_attr2 = $this->product_attr;
            $product_attr2['warehouse_id'] = $WMS->id;
            $product_attr2['code'] = 'CODE-02';
            $product_attr2['name'] = 'PR-02';
            $product_attr2['is_available'] = false;
            $product2 = StoreProduct::dispatchNow(null, $product_attr2);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        try {
            $product_attr3 = $this->product_attr;
            $product_attr3['warehouse_id'] = $WMS->id;
            $product_attr3['code'] = 'CODE-03';
            $product_attr3['name'] = 'PR-03';
            $product_attr3['is_available'] = true;
            $product3 = StoreProduct::dispatchNow(null, $product_attr3);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }
        
        $this->StockCard['warehouse_id'] = $WMS->id;

        /*----------  Basic  ----------*/
        $stock_card_attr = $this->StockCard;

        try {
            $stock_card_attr['date'] = now();
            $stock_card = StoreStockCard::dispatchNow(null, $stock_card_attr);
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        /*----------  StockCard Disc > StockCard Total  ----------*/
        $stock_card_attr2 = $this->StockCard;

        try {
            $stock_card_attr2['no'] = 'INV-02';
            $stock_card_attr2['date'] = now();
            $stock_card_attr2['discount'] = 10000000;
            StoreStockCard::dispatchNow(null, $stock_card_attr2);
            $this->assertTrue(false);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('lte:250000', $e->errors()['discount']));
        }


        /*----------  Product Exists, Available & HasPrice  ----------*/
        $stock_card_attr3 = $this->StockCard;
        try {
            $stock_card_attr3['no']       = '0002';
            $stock_card_attr3['lines'][] = [
                'product_id' => $product2->id,
                'qty'        => 3,
                'price'      => 30000,
                'discount'   => 0
            ];

            $stock_card_attr3['lines'][] = [
                'product_id' => $product3->id,
                'qty'        => 3,
                'price'      => 30000,
                'discount'   => 0
            ];

            StoreStockCard::dispatchNow(null, $stock_card_attr3);
            $this->assertTrue(false);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('invalid:NOT_AVAILABLE', $e->errors()['lines.1.product_id']));
            $this->assertTrue(in_array('invalid:HAS_NO_PRICE', $e->errors()['lines.2.product_id']));
        }

        /*----------  Delete StockCard  ----------*/
        try {
            DeleteStockCard::dispatchNow($stock_card->id);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('NOT_DELETABLE', $e->errors()['id']));
        }

        /*----------  Void StockCard  ---xw-------*/
        try {
            CancelStockCard::dispatchNow($stock_card->id);
            $stock_card = StockCard::find($stock_card->id);
            $this->assertNotNull($stock_card->cancelled_at);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        /*----------  Void StockCard Has Settlements  ----------*/
        try {
            $stock_card->settlements()->create([
                'no'     => $stock_card->no,
                'date'   => $stock_card->date,
                'type'   => Settlement::CASH,
                'amount' => $stock_card->getBalance()
            ]);
        } catch (ValidationException $e) {
            dd($e->errors());
        }
        
        
    }
}
