<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;
use App\BallotVotes;


class Ballot extends Model
{
    protected $fillable = [
		'name',
		'user_id',
		'expiration',
		'type',
		'status',
		'consensus',
		'class_restriction'
	];
	
	public function content(){
		return $this->hasMany('App\BallotContent','ballot_id');
	}
	
	public function votes(){
		return $this->hasMany('App\BallotVotes','ballot_id');
	}
	
	public function questions(){
		return $this->hasMany('App\BallotQuestion','ballot_id');
	}
	
	public function owner(){
		return $this->belongsTo('App\User','user_id');
	}
	
	public function support(){
		return $this->hasMany('App\BallotSupport','ballot_id'); // Has many through?
	}
	
	public function supporters(){
		return $this->belongsToMany('App\User','ballot_supports'); 
	}
	
	public function voters(){
		return $this->hasManyThrough('App\User','App\BallotVotes','user_id','id');
	}
	
	/*public function supporters(){
		return $this->hasManyThrough('App\User','App\BallotSupport','user_id','ballot_id'); // Has many through?
	} */
	
	
	public function checkUserVote($user_id){
		$vote_check = $this->votes()->where('user_id', $user_id)->first();
		if($vote_check) :
			return true;
		else :
			return false;
		endif;
	}
	
	public function checkUserSupport($user_id){
		$support_check = $this->support()->where('user_id', $user_id)->first();
		if($support_check) :
			return true;
		else :
			return false;
		endif;
	}
	
	public function isBallotPrivate(){
		return $this->type;
	}
	
	public function vote($question_id,$vote){
		
	}
	
	//if the expiration date is greater than the current date, the ballot has not expired, so this is false
	public function isExpired(){

		if($this->status == 2) :
			return true;
		else :
			return false;
		endif;
	}
	
	public function quorum($users){
		//Get A Members Votes
		$ballot_id = $this->id;
		$votes = User::whereHas('votes', function ($query) use ($ballot_id) {
    				$query->where('ballot_id', $ballot_id);
				}, '>', 0)
				->whereHas('roles', function ($query) use ($ballot_id){
            		$query->where('role_id',3); //3 for test
        		})->get()->count();
				
		if($votes >= floor($users*.75)) :
			return true;
		else :
			return false;
		endif;
	}
	
	public function ballotType(){
		$types = array(0 => 'Public', 1 => 'Private');
		return $types[$this->type];
	}
	
	public function ballotStatus(){
		$status = array(0 => 'Unsupported', 1 => 'Supported', 2 => 'Closed');
		return $status[$this->status];
	}
	
	public function ballotRowColor(){
		$status = array(0 => 'warning', 1 => 'success', 2 => 'danger');
		return $status[$this->status];
	}
	
	public function tally(){
		
		$ballot_id = $this->id;
		
		$total_voters = User::whereHas('votes', function ($query) use ($ballot_id) {
    				$query->where('ballot_id', $ballot_id);
				}, '>', 0)->get()->count();
		
		//Get the # of A voters
		$a_voters = User::whereHas('votes', function ($query) use ($ballot_id) {
    				$query->where('ballot_id', $ballot_id);
				}, '>', 0)
				->whereHas('roles', function ($query) use ($ballot_id){
            		$query->where('role_id',3); //3 for test
        		})->get()->count();
				
		//Get the # of B voters
		$b_voters = User::whereHas('votes', function ($query) use ($ballot_id) {
    				$query->where('ballot_id', $ballot_id);
				}, '>', 0)
				->whereHas('roles', function ($query) use ($ballot_id){
            		$query->where('role_id',4); //3 for test
        		})->get()->count();
				
	
		$step_two = $a_voters/4; 

		if($b_voters > 0): 
			$b_member_vote_percentage = $step_two/$b_voters;
		endif;
		
		//Each B members gets the $b_member_vote_percentage, so now we have to multiply the B votes in each category by that, add them to the total, and spit out a number. FML. 
		
		//Get the votes of all the A users
		$a_votes = BallotVotes::select('vote')->with(['user','user.roles' => function($query){
       			 $query->where('role_id',4);
   		 }])->where('ballot_id',$ballot_id)->get();
		 
		 //Get the votes of all the B users
		$b_votes = BallotVotes::with(['user','user.roles' => function($query){
       			 $query->where('role_id',4);
   		 }])->where('ballot_id',$ballot_id)->get();
		
		//Get the actual B votes and loop through and multiply the B votes by the percetage. 
	
		//Get the A votes grouped by response
		return $a_votes;
	}
	
}