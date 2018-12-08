<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract{

    use Authenticatable, Authorizable, CanResetPassword;

    /*---------------------------------------*/

    protected $fillable = ['email', 'password'];
    public $timestamps = false;
    protected $hidden = ['password', 'remember_token'];
    protected $primaryKey = "id_u";

    /*---------------------------------------*/

    /**
     * Check if user has specific role
     * @param string $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if($this->role->name == $role){
            return true;
        }
        return false;
    }


    public function isDeactivated(){
        if(!empty($this->deact_date)){
            return true;
        }
        return false;
    }
    /**
     * Returns the fullname of user
     * @return string
     */
    public function getFullname(){
        return $this->firstname." ".$this->surname;
    }
    /**
     * Return role related to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(){
        return $this->belongsTo('App\Role',"role_id");
    }
    public function messages(){
        return $this->belongsToMany('App\Message', 'mes_use','user_id','message_id')->withPivot('seen')->orderBy('sent_at', 'desc');
    }
    public function groups(){
        return $this->belongsToMany('App\Group', 'use_gro','student_id','group_id')->withPivot('added');
    }
}

