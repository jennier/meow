<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class HrReport extends Model
{
    protected $fillable = [
		'user_id',
		'event_id',
		'type',
	];
	
	public function owner(){
		return $this->belongsTo('App\User','user_id');
	}

	public function event(){
		return $this->belongsTo('App\HrEvent','event_id');
	}
	
	public function reportType(){
		if($this->type == 0) :
			return 'Submitter';
		elseif($this->type == 1) :
			return 'Reported';
		endif;
	}
}