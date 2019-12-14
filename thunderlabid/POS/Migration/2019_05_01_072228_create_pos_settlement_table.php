<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosSettlementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('POS_settlements', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('invoice_id')->index();
            $table->string('no')->index();
            $table->string('date')->index();
            $table->string('type');
            $table->string('ref_no')->nullable();
            $table->double('amount', 18, 0);
            $table->datetime('cancelled_at')->nullable();
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
        Schema::dropIfExists('POS_settlements');
    }
}
