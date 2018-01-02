<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class HrEvent extends Model
{
    protected $fillable = [
		'description',
		'type',
		'status',
	];
	
	public function logs(){
		return $this->hasMany('App\HrLog','event_id');
	}

	public function reports(){
		return $this->hasMany('App\HrReport','event_id');
	}
	
	public function points(){
		return $this->hasMany('App\HrPoint','event_id');
	}

	public function logs(){
		return $this->hasMany('App\HrLog','event_id');
	}

	public function showStatus(){
		if($this->status == 0) :
			return 'Open';
		elseif($this->status == 1) :
			return 'Closed';
		endif;
	}

	public function showType(){
		if($this->status == 0) :
			return 'Tardiness';
		elseif($this->status == 1) :
			return 'Absense';
		elseif($this->status == 2) :
			return 'Conduct';
		elseif($this->status == 3) :
			return 'Compliment';
		elseif($this->status == 4) :
			return 'Other';
		endif;
	}
}