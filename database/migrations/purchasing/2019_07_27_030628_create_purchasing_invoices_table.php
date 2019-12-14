<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasingInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('org_id')->index();
            $table->bigInteger('partner_id')->nullable()->index();
            
            $table->string('no')->nullable();
            $table->datetime('issued_at')->nullable();
            $table->json('lines');

            $table->timestamps();

            $table->index(['org_id', 'issued_at', 'partner_id'], 'p_invoices_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchasing_invoices');
    }
}
