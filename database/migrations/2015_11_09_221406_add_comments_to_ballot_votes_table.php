<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentsToBallotVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ballot_votes', function(Blueprint $table)
        {
			$table->string('comments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ballot_votes', function(Blueprint $table)
        {
			$table->dropColumn('comments');

        });
    }

}
