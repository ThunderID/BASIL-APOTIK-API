<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('org_id')->index();
            $table->bigInteger('user_id')->index();
            $table->datetime('opened_at')->index();
            $table->datetime('closed_at')->nullable();
            $table->double('closing_balance')->nullable();
            $table->double('variance')->nullable();
            $table->string('department')->default('FO');
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
        Schema::dropIfExists('cashier_sessions');
    }
}
