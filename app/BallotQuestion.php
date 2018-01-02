<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class BallotQuestion extends Model
{
    protected $fillable = [
		'ballot_id',
		'question',
		'type',
	];
	
	public function ballot(){
		return $this->belongsTo('App\Ballots','ballot_id');
	}
	
	public function votes(){
		return $this->hasMany('App\BallotVotes','question_id');
	}
	
	public function choices(){
		return $this->hasMany('App\BallotQuestionChoice','question_id');
	}
	
	public function vote(){
		$question_id = $this->id;
		//$vote is the voting option we're looking at 
	
		// Class A
		$class_a = User::whereHas('votes', function ($query) use ($question_id) {
    				$query->where('question_id', $question_id);
				}, '>', 0)
				->whereHas('roles', function ($query) use ($question_id){
            		$query->where('role_id',3); //3 for test
        		})->get()->count();
				
		print_r($class_a);
		
	
		// Class B ($class_a/$class_b) * .25
		$class_b = User::whereHas('votes', function ($query) use ($question_id) {
    				$query->where('question_id', $question_id);
				}, '>', 0)
				->whereHas('roles', function ($query) use ($question_id){
            		$query->where('role_id',4); //4 for test
        		})->get()->count();
				
		print_r($class_b);
	}
	
	public function showVote($vote){
		if($this->type == 2) :
			$votes = $this->choices->keyBy('id'); // where the choice id is equal to the vote id
			return $votes->get($vote)->name;
		elseif($this->type == 1) :
			return $vote;
		else :
			$votes = array(0 => 'Yes', 1 => 'No', 2 => 'Stand Aside');
			return $votes[$vote];
		endif; 
	}
	
	
	public function passed($users){
		if($this->votes()->where('vote',0)->count() >= ($users*.66)) :
			return true;
		else :
			return false;
		endif;
	}
	
}