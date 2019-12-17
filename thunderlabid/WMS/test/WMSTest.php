<?php

namespace Thunderlabid\WMS\Test;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

use Thunderlabid\WMS\Warehouse;
use Thunderlabid\WMS\Job\Warehouse\Store as StoreWarehouse;
use Thunderlabid\WMS\Job\Warehouse\Delete as DeleteWarehouse;

class WMSTest extends TestCase
{
    use RefreshDatabase;

    protected $warehouse_attr = [
        'name'           => 'WMS-A',
        'is_active'      => true,
    ];

    public function testWarehouse()
    {
        $attr = $this->warehouse_attr;

        /*----------  Basic  ----------*/
        try {
            $data = StoreWarehouse::dispatchNow(null, $attr);
            // $data = Warehouse::create($attr);
            $this->assertNotNull($data->id);
        } catch (ValidationException $e) {
            dd($e->errors());
        }

        /*----------  Duplicate  ----------*/
        $attr = $this->warehouse_attr;
        try {
            $data2 = StoreWarehouse::dispatchNow(null, $attr);
            // $data = Warehouse::create($attr);
            $this->assertTrue(false);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('unique', $e->errors()['name']));
        }

        /*----------  Edit  ----------*/
        $attr = $this->warehouse_attr;
        try {
            $data = StoreWarehouse::dispatchNow($data->id, ['name' => 'WMS-1']);
            $this->assertTrue($data->name == 'WMS-1');
        } catch (ValidationException $e) {
            dd($e->errors());
        }

        /*----------  Delete Basic  ----------*/
        try {
            $is_deleted = DeleteWarehouse::dispatchNow($data->id);
            $this->assertTrue($is_deleted);
        } catch (ValidationException $e) {
            dd($e->errors());
        }
    }

    public function testDeleteWMSHasStockCard()
    {
        $attr = $this->warehouse_attr;

        /*----------  Prepare Data  ----------*/
        try {
            $data = StoreWarehouse::dispatchNow(null, $attr);
            // $data = Warehouse::create($attr);
            $data->StockCards()->create([
                'no'       => '1',
                'date'     => now(),
                'customer' => 'customer',
                'discount' => 0,
                'tax'      => 0,
                'lines'    => [
                    [
                        'product_id' => 1,
                        'code'       => '0001', 
                        'name'       => 'PR-01', 
                        'qty'        => 5, 
                        'price'      => 25000,
                        'discount'   => 0
                    ]
                ],
            ]);
        } catch (ValidationException $e) {
            dd($e->errors());
        }

        /*----------  Delete  ----------*/
        try {
            $data->delete();
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('immutable:HAS_StockCardS', $e->errors()['id']));
        }
    }

    public function testDeleteWMSHasProduct()
    {
        $attr = $this->warehouse_attr;

        /*----------  Prepare Data  ----------*/
        try {
            $data = StoreWarehouse::dispatchNow(null, $attr);
            // $data = Warehouse::create($attr);
            $data->products()->create([
                'code'         => '0001', 
                'name'         => 'PR-01', 
                'description'  => '5', 
                'is_available' => true
            ]);
        } catch (ValidationException $e) {
            dd($e->errors());
        }

        /*----------  Delete  ----------*/
        try {
            $data->delete();
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('immutable:HAS_PRODUCTS', $e->errors()['id']));
        }
    }
}
