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

use Thunderlabid\POS\Job\Settlement\Store as StoreSettlement;
use Thunderlabid\POS\Job\Settlement\Delete as DeleteSettlement;
use Thunderlabid\POS\Job\Settlement\Cancel as CancelSettlement;

use Thunderlabid\POS\Job\Product\Price\Add as AddPrice;
use Thunderlabid\POS\Job\Product\Price\Delete as DeletePrice;

use Arr;

class SettlementTest extends TestCase
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

    protected $settlement = [
        'no'   => 'SET-01',
        'type' => Settlement::CASH
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

        // Invoice 1
        $invoice_attr = $this->invoice;
        try {
            $invoice_attr['date'] = now();
            $invoice1 = StoreInvoice::dispatchNow(null, $invoice_attr);
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        // Invoice 2
        $invoice_attr2 = $this->invoice;
        try {
            $invoice_attr2['no'] = 'INV-02';
            $invoice_attr2['date'] = now();
            $invoice2 = StoreInvoice::dispatchNow(null, $invoice_attr2);
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        /*----------  Settlement Error: Amount > Invoice Balance, date < invoice date   ----------*/
        $settlement_attr1 = $this->settlement;
        $settlement_attr1['invoice_id'] = $invoice1->id;
        $settlement_attr1['date'] = $invoice1->date->subDay();
        $settlement_attr1['amount'] = $invoice1->getBalance() * 2;
        try {
            $settlement1 = StoreSettlement::dispatchNow(null, $settlement_attr1);
            $this->assertTrue(false);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('after_or_equal:' . $invoice1->date , $e->errors()['date']));
            $this->assertTrue(in_array('lte_numeric:' . $invoice1->getBalance(), $e->errors()['amount']));
        }


        /*----------  Settlement 1: partial, Settlement 2: > Balance  ----------*/
        $settlement_attr2 = $this->settlement;
        $settlement_attr2['no'] = $invoice2->id;
        $settlement_attr2['invoice_id'] = $invoice2->id;
        $settlement_attr2['date'] = $invoice2->date;
        $settlement_attr2['amount'] = $invoice2->getBalance() - 1000;
        try {
            $settlement2 = StoreSettlement::dispatchNow(null, $settlement_attr2);
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        try {
            $settlement_attr3 = $settlement_attr2;
            $settlement_attr3['no'] = $invoice2->id + 1;
            $settlement3 = StoreSettlement::dispatchNow(null, $settlement_attr3);
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $invoice2 = Invoice::find($invoice2->id);
            $this->assertTrue(in_array('lte_numeric:' . $invoice2->getBalance(), $e->errors()['amount']));
        }

        /*----------  Settlement Success  ----------*/
        try {
            $settlement_attr4 = $settlement_attr2;
            $settlement_attr4['no'] = $invoice2->id + 1;
            $settlement_attr4['amount'] = 1000;
            $settlement4 = StoreSettlement::dispatchNow(null, $settlement_attr4);
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }

        /*----------  Delete Settlement   ----------*/
        try {
            DeleteSettlement::dispatchNow($settlement4->id);
        } catch (ValidationException $e) {
            $this->assertTrue(in_array('immutable', $e->errors()['id']));
        }

        /*----------  Cancel Settlement   ----------*/
        try {
            CancelSettlement::dispatchNow($settlement4->id);
            $this->assertTrue(true);
        } catch (ValidationException $e) {
            dd($e->errors());
            $this->assertTrue(false);
        }

        // Repay invoice 4
        try {
            $settlement_attr5 = $settlement_attr2;
            $settlement_attr5['no'] = now();
            $settlement_attr5['amount'] = 1000;
            $settlement5 = StoreSettlement::dispatchNow(null, $settlement_attr5);

            $settlement5->load('invoice');
            $this->assertTrue($settlement5->invoice->getBalance() == 0);
        } catch (ValidationException $e) {
            $this->assertTrue(false);
        }
        
        
    }
}
