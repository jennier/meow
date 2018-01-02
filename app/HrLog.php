<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class HrLog extends Model
{
    protected $fillable = [
		'user_id',
		'event_id',
		'interaction',
		'comments',
	];
	
	public function owner(){
		return $this->belongsTo('App\User','user_id');
	}

	public function event(){
		return $this->belongsTo('App\HrEvent','event_id');
	}

}