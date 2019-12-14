<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('user_id');

            $table->string('name');
            $table->string('phone');

            $table->string('title')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('pin')->nullable();
            $table->string('passport')->nullable();
            $table->json('address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bios');
    }
}
