<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('POS_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('pos_point_id')->index();
            $table->string('code')->index();
            $table->string('name')->index();
            $table->string('group')->nullable()->index();
            $table->text('description')->nullable();
            $table->boolean('is_available')->default(0)->index();
            $table->timestamps();
            
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
        Schema::dropIfExists('POS_products');
    }
}
