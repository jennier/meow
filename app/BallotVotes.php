<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class BallotVotes extends Model
{
	protected $table = "ballot_votes";
	
    protected $fillable = ['vote','ballot_id','user_id','comments','question_id'];
	
	public function ballot(){
		return $this->belongsTo('App\Ballots','ballot_id');
	}
	
	public function user(){
		return $this->belongsTo('App\User','user_id');
	}
	
	public function question(){
		return $this->belongsTo('App\BallotQuestions','question_id');
	}
	
	public function roles(){
		return $this->hasManyThrough('App\Role', 'App\User');
	}
	
}