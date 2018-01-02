<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionsOption extends Model
{
    protected $fillable = [
		'question_id',
		'name',
	];
	
	public function question(){
		return $this->belongsTo('App\SurveyQuestions','question_id');
	}
}