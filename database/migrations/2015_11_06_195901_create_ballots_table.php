<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBallotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ballots', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('user_id');
			$table->string('name');
			$table->date('expiration');
			$table->enum('type', array('0', '1')); //Public, Private
			$table->enum('status', array('0', '1', '2')); //Unsupported, Open, Closed
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
        Schema::drop('ballots');
    }

}
