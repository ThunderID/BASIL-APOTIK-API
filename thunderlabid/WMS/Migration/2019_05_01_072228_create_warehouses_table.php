<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('WMS_warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('org_id')->index();
            $table->string('name')->index();
            $table->string('department')->nullable();
            $table->boolean('is_active')->default(0)->index();
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
        Schema::dropIfExists('WMS_warehouses');
    }
}
