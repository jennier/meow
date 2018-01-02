<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_responses', function(Blueprint $table)
        {
            $table->increments('id');
			$table->integer('survey_id');
			$table->integer('user_id');
			$table->integer('question_id');
			$table->text('response');
			$table->timestamp('created');
			$table->timestamp('updated');

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
        Schema::drop('survey_responses');
    }

}
