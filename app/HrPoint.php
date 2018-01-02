<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class HrPoint extends Model
{
    protected $fillable = [
		'user_id',
		'value',
	];
	
	public function owner(){
		return $this->belongsTo('App\User','user_id');
	}

	public function event(){
		return $this->belongsTo('App\HrEvent','event_id');
	}

}