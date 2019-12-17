<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('product_id');
            $table->datetime('active_at');
            $table->double('price', 18, 0);
            $table->double('discount', 18, 0)->index();
            $table->timestamps();
            $table->softdeletes();
            
            /*----------  INDEX  ----------*/
            $table->index(['product_id', 'active_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
