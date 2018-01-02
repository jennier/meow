<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $fillable = [
		'survey_id',
		'question',
		'type',
		'created_at',
		'updated_at',
	];
	
	public function survey(){
		return $this->belongsTo('App\Surveys','survey_id');
	}
	
	public function groups(){
		return $this->belongsTo('App\SurveyQuestionGroup','group_id');
	}
	
	public function responses(){
		return $this->hasMany('App\SurveyResponse','question_id');
	}
	
	public function options(){
		return $this->hasMany('App\SurveyQuestionsOption','question_id');
	}
	
	public function responseType($response){
	
		
		if($this->type == 0) :
		
			$choices = array('Yes','No');
			$response = $choices[$response];
			
		elseif($this->type == 2) :
	
			foreach($this->options as $option) :
				$options[] = $option->name;
			endforeach;
			
			$response = $options[$response];
			
		endif ;
		
		return $response;
		
	}
	
}