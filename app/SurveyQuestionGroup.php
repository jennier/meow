<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionGroup extends Model
{
    protected $fillable = [
		'survey_id',
		'name',
	];
	
	public function questions(){
		return $this->hasMany('App\SurveyQuestion','group_id');
	}
	
	public function survey(){
		return $this->belongsTo('App\Survey','survey_id');
	}
	
}