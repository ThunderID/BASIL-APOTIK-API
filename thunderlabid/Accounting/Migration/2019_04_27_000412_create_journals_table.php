<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ACCT_journal_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('org_id')->index();
            $table->string('no')->unique();
            $table->nullableMorphs('ref');
            $table->date('date');
            $table->string('note')->nullable();
            $table->timestamp('locked_at')->nullable()->index();
            $table->timestamp('void_at')->nullable()->index();
            $table->json('lines');
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
        Schema::dropIfExists('ACCT_journal_entries');
    }
}
