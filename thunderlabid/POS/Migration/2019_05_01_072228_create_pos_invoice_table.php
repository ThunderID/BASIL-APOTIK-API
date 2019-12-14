<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('POS_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('pos_point_id')->index();
            $table->string('no')->index();
            $table->string('date')->index();
            $table->string('customer');
            $table->text('lines');
            $table->double('discount', 18, 0);
            $table->double('tax', 18, 0);
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
        Schema::dropIfExists('POS_invoices');
    }
}
