<?php

namespace Thunderlabid\POS\Test;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

use Thunderlabid\POS\POSPoint;
use Thunderlabid\POS\Invoice;
use Thunderlabid\POS\Product;
use Thunderlabid\POS\Settlement;
use Thunderlabid\POS\Job\POSPoint\Store as StorePOSPoint;
use Thunderlabid\POS\Job\POSPoint\Delete as DeletePOSPoint;

use Thunderlabid\POS\Job\Product\Store as StoreProduct;
use Thunderlabid\POS\Job\Product\Delete as DeleteProduct;

use Thunderlabid\POS\Job\Invoice\Store as StoreInvoice;
use Thunderlabid\POS\Job\Invoice\Delete as DeleteInvoice;
use Thunderlabid\POS\Job\Invoice\Cancel as CancelInvoice;
use Thunderlabid\POS\Job\Product\Price\Add as AddPrice;
use Thunderlabid\POS\Job\Product\Price\Delete as DeletePrice;

use Arr;

class InvoiceTest extends TestCase
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

    protected $invoice = [
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
        $attr = $this->pos_point_attr;
        $pos = StorePOSPoint::dispatchNow(null, $attr);

        try {
            $product_attr1 = $this->product_attr;
            $product_attr1['pos_point_id'] = $pos->id;
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
            $product_attr2['pos_point_id'] = $pos->id;
            $product_attr2['code'] = 'CODE-02';
            $product_attr2['name'] = 'PR-02';
            $product_attr2['is_available'] = false;
            $product2 = StoreProduct::dispatchNow(null, $product_attr2);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        try {
            $product_attr3 = $this->product_attr;
            $product_attr3['pos_point_id'] = $pos->id;
            $product_attr3['code'] = 'CODE-03';
            $product_attr3['name'] = 'PR-03';
            $product_attr3['is_available'] = true;
            $product3 = StoreProduct::dispatchNow(null, $product_attr3);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }
        
        $this->invoice['pos_point_id'] = $pos->id;

        /*----------  Basic  ----------*/
        $invoice_attr = $this->invoice;

        try {
            $invoice_attr['date'] = now();
            $invoice = StoreInvoice::dispatchNow(null, $invoice_attr);
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        /*----------  Invoice Disc > Invoice Total  ----------*/
        $invoice_attr2 = $this->invoice;

        try {
            $invoice_attr2['no'] = 'INV-02';
            $invoice_attr2['date'] = now();
            $invoice_attr2['discount'] = 10000000;
            StoreInvoice::dispatchNow(null, $invoice_attr2);
            $this->assertTrue(false);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('lte:250000', $e->errors()['discount']));
        }


        /*----------  Product Exists, Available & HasPrice  ----------*/
        $invoice_attr3 = $this->invoice;
        try {
            $invoice_attr3['no']       = '0002';
            $invoice_attr3['lines'][] = [
                'product_id' => $product2->id,
                'qty'        => 3,
                'price'      => 30000,
                'discount'   => 0
            ];

            $invoice_attr3['lines'][] = [
                'product_id' => $product3->id,
                'qty'        => 3,
                'price'      => 30000,
                'discount'   => 0
            ];

            StoreInvoice::dispatchNow(null, $invoice_attr3);
            $this->assertTrue(false);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('invalid:NOT_AVAILABLE', $e->errors()['lines.1.product_id']));
            $this->assertTrue(in_array('invalid:HAS_NO_PRICE', $e->errors()['lines.2.product_id']));
        }

        /*----------  Delete Invoice  ----------*/
        try {
            DeleteInvoice::dispatchNow($invoice->id);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('NOT_DELETABLE', $e->errors()['id']));
        }

        /*----------  Void Invoice  ---xw-------*/
        try {
            CancelInvoice::dispatchNow($invoice->id);
            $invoice = Invoice::find($invoice->id);
            $this->assertNotNull($invoice->cancelled_at);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        /*----------  Void Invoice Has Settlements  ----------*/
        try {
            $invoice->settlements()->create([
                'no'     => $invoice->no,
                'date'   => $invoice->date,
                'type'   => Settlement::CASH,
                'amount' => $invoice->getBalance()
            ]);
        } catch (ValidationException $e) {
            dd($e->errors());
        }
        
        
    }
}
