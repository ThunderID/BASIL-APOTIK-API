<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cashier_session_id')->index();
            $table->string('method')->index();
            $table->double('amount');
            $table->integer('ref_id')->unsigned()->nullable();
            $table->string('ref_type')->nullable();
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
        Schema::dropIfExists('cashier_logs');
    }
}
