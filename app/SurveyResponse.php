<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $fillable = [
		'survey_id',
		'user_id',
		'question_id',
		'response',
		'created',
		'updated',
	];
	
	public function survey(){
		return $this->belongsTo('App\Surveys','survey_id');
	}
	
	public function user(){
		return $this->belongsTo('App\User','user_id');
	}
	
	public function question(){
		return $this->belongsTo('App\SurveyResponse','question_id');
	}
	
}