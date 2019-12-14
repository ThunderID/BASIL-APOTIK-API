<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('org_id')->index();
            $table->string('code')->index();
            $table->string('name')->index();
            $table->string('group')->nullable()->index();
            $table->text('description')->nullable();
            $table->string('unit')->default('pc');
            $table->bigInteger('threshold')->default(2);
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
        Schema::dropIfExists('products');
    }
}
