<?php namespace App;
   
use Illuminate\Database\Eloquent\Model;

class CrReport extends Model
{
    protected $fillable = [
		'user_id',
		'client',
		'type',
		'content',
	];
	
	public function owner(){
		return $this->belongsTo('App\User','user_id');
	}
	
	public function reportType(){
		if($this->type == 0) :
			return 'Complaint';
		elseif($this->type == 1) :
			return 'Compliment';
		elseif($this->type == 2) :
			return 'New client';
		endif;
	}
}