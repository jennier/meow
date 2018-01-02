<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function(Blueprint $table)
        {
            $table->increments('id');
			$table->string('name');
			$table->integer('user_id');
			$table->integer('status');
			$table->datetime('expiration');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
			$table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('surveys');
    }

}
