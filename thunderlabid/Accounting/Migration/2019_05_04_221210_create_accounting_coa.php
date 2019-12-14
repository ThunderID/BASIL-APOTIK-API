<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingCoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ACCT_coas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('org_id')->index();
            $table->bigInteger('parent_id')->nullable()->index();
            $table->string('type')->index();
            $table->string('code')->index();
            $table->string('name');
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->boolean('has_subsidiary')->default(false);
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
        Schema::dropIfExists('ACCT_coas');
    }
}
