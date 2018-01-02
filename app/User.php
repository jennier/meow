<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, EntrustUserTrait {
	
	EntrustUserTrait::can as may;
    Authorizable::can insteadof EntrustUserTrait;
	
	}

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
	
	
	// The ballots that belong to this user
	public function ballots(){
		return $this->hasMany('App\Ballots','user_id');	
	}
	
	// The votes that beling to this user
	public function votes(){
		return $this->hasMany('App\BallotVotes');	
	}
	
	// The votes that beling to this user
	public function vote(){
		return $this->belongsTo('App\BallotVotes');	
	}
	
    // The roles that belong to the user.
    public function roles(){
        return $this->belongsToMany('App\Role');
    }
	
	// The survey responses that beling to this user
	public function responses(){
		return $this->hasMany('App\SurveyResponse');	
	}
	
	// The CR reports that belong to this user
	public function crReports(){
		return $this->hasMany('App\CrReports','user_id');	
	}
	
	// Ballots the user supports.
	public function supports(){
		return $this->belongsToMany('App\Ballots','ballot_supports');
	}

	// The HR reports that belong to this user
	public function hrReports(){
		return $this->hasMany('App\HrReports','user_id');	
	}

	// HR points belonging to this user
	public function hrPoints(){
		return $this->hasMany('App\HrPoints','user_id');
	}
	
	
}
