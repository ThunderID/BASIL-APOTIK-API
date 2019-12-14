<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ACCT_journal_entry_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('journal_entry_id')->index();
            $table->bigInteger('coa_id')->index();
            $table->bigInteger('subsidiary_coa_id')->nullable()->index();
            $table->decimal('amount', 16, 2);
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
        Schema::dropIfExists('ACCT_journal_entry_lines');
    }
}
