<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_events', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('description');
            $table->enum('type', array('0', '1', '2', '3', '4')); //Late, Absense, Conduct, Compliment, Other
            $table->enum('status', array('0', '1')); //Open, Closed
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
        Schema::drop('hr_events');
    }
}
