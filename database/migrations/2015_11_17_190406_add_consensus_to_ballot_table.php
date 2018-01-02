<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConsensusToBallotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ballots', function(Blueprint $table)
        {
			$table->enum('consensus', ['quorum', 'majority']);
			$table->enum('class_restriction', [0, 1]);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ballots', function(Blueprint $table)
        {
			$table->dropColumn('consensus');
			$table->dropColumn('class_restriction');
        });
    }

}
