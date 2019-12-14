<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHRAbsentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_absents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('at');
            $table->bigInteger('user_id');
            $table->bigInteger('org_id');
            $table->boolean('is_in_office');
            $table->text('geolocation')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('hr_absents');
    }
}
