<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWMSStockCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('WMS_stock_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('warehouse_id')->index();
            $table->morphs('ref');
            $table->bigInteger('product_id')->index();
            $table->double('qty');
            $table->datetime('date');
            $table->string('sku');
            $table->datetime('expired_at')->nullable();
            $table->timestamps();
            $table->softdeletes();
            
            /*----------  INDEX  ----------*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('WMS_stock_cards');
    }
}
