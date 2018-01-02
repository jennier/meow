<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class HrReport extends Model
{
    protected $fillable = [
		'type',
	];
	
	public function event(){
		return $this->belongsToMany('App\HrEvent','event_id');
	}
	
}