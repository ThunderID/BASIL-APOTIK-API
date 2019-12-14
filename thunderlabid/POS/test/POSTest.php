<?php

namespace Thunderlabid\POS\Test;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

use Thunderlabid\POS\POSPoint;
use Thunderlabid\POS\Job\POSPoint\Store as StorePOSPoint;
use Thunderlabid\POS\Job\POSPoint\Delete as DeletePOSPoint;

class POSTest extends TestCase
{
    use RefreshDatabase;

    protected $pos_point_attr = [
        'name'           => 'POS-A',
        'is_active'      => true,
    ];

    public function testPOSPoint()
    {
        $attr = $this->pos_point_attr;

        /*----------  Basic  ----------*/
        try {
            $data = StorePOSPoint::dispatchNow(null, $attr);
            // $data = POSPoint::create($attr);
            $this->assertNotNull($data->id);
        } catch (ValidationException $e) {
            dd($e->errors());
        }

        /*----------  Duplicate  ----------*/
        $attr = $this->pos_point_attr;
        try {
            $data2 = StorePOSPoint::dispatchNow(null, $attr);
            // $data = POSPoint::create($attr);
            $this->assertTrue(false);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('unique', $e->errors()['name']));
        }

        /*----------  Edit  ----------*/
        $attr = $this->pos_point_attr;
        try {
            $data = StorePOSPoint::dispatchNow($data->id, ['name' => 'POS-1']);
            $this->assertTrue($data->name == 'POS-1');
        } catch (ValidationException $e) {
            dd($e->errors());
        }

        /*----------  Delete Basic  ----------*/
        try {
            $is_deleted = DeletePOSPoint::dispatchNow($data->id);
            $this->assertTrue($is_deleted);
        } catch (ValidationException $e) {
            dd($e->errors());
        }
    }

    public function testDeletePOSHasInvoice()
    {
        $attr = $this->pos_point_attr;

        /*----------  Prepare Data  ----------*/
        try {
            $data = StorePOSPoint::dispatchNow(null, $attr);
            // $data = POSPoint::create($attr);
            $data->invoices()->create([
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
            $this->assertTrue(in_array('immutable:HAS_INVOICES', $e->errors()['id']));
        }
    }

    public function testDeletePOSHasProduct()
    {
        $attr = $this->pos_point_attr;

        /*----------  Prepare Data  ----------*/
        try {
            $data = StorePOSPoint::dispatchNow(null, $attr);
            // $data = POSPoint::create($attr);
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
