<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BallotContent extends Model
{
	protected $table = "ballot_contents";
	
    protected $fillable = ['ballot_id','text','link','version'];
	
    public function ballot(){
		return $this->belongsTo('App\Ballots','ballot_id');
	}
}
