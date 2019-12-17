<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWMSGRNsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('WMS_GRNs', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('warehouse_id')->index();
            $table->string('no')->index();
            $table->string('date')->index();
            $table->integer('ref_id')->unsigned()->nullable();
            $table->string('ref_type')->nullable();
            $table->text('lines');
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
        Schema::dropIfExists('WMS_GRNs');
    }
}
