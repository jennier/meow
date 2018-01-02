<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	protected $fillable = ['name', 'display_name', 'description'];
	
	/**
    * The users that belong to the role.
    */
    public function users(){
        return $this->belongsToMany('App\User','user_id');
    }
	
	/**
    * The permissions that belong to the role.
    */
    public function permissions(){
        return $this->belongsToMany('App\Permission');
    }
	
}

