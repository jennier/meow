<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
		'id',
		'name',
		'description',
		'status',
	];
	
	public function responses(){
		return $this->hasMany('App\SurveyResponse','survey_id');
	}
	
	public function questions(){
		return $this->hasMany('App\SurveyQuestion','survey_id');
	}
	
	public function groups(){
		return $this->hasMany('App\SurveyQuestionGroup','survey_id');
	}
	
	public function owner(){
		return $this->belongsTo('App\User','user_id');
	}
	
	public function checkUserResponse($user_id){
		$vote_check = $this->responses()->where('user_id', $user_id)->first();
		if($vote_check) :
			return true;
		else :
			return false;
		endif;
	}
}