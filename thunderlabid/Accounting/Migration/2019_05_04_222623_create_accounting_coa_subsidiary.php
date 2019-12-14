<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingCoaSubsidiary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ACCT_coa_subsidiaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('coa_id');
            $table->nullableMorphs('ref');
            $table->string('code')->index();
            $table->string('name');
            $table->text('data')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ACCT_coa_subsidiaries');
    }
}
