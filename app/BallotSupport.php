<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class BallotSupport extends Model
{
    protected $fillable = [
		'ballot_id',
		'user_id',
	];
	
	public function ballot(){
		return $this->belongsTo('App\Ballot','ballot_id');
	}
	
	public function supporters(){
		return $this->belongsToMany('App\User','user_id'); 
	}
}