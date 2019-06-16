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
    //protected $dates = ["registered","last_login","deact_date"];
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
    public function inCourses(){
        $g = [];
        $temp = $this->inGroups;
        foreach($temp as $t){
            foreach($t->courses as $c){
                $g[] = $c;
            }
        }
        return $g;
    }

    /**
     * Relationship between groups and user
     * @return Group[]|array|\Illuminate\Database\Eloquent\Collection
     */
    public function ownGroups(){
        if($this->hasRole('admin')){
            return Group::all();
        }else if($this->hasRole('user')){
            return collect([]);
        }
        return $this->hasMany('App\Group',"owner_id")->get();
    }
    public function inGroups(){
        return $this->belongsToMany('App\Group', 'use_gro','student_id','group_id')->withPivot('added');
    }
    /**
     * Relationship between courses and users
     * @return Course[]|\Illuminate\Database\Eloquent\Collection
     */
    public function ownCourses(){
        if($this->role->name == "admin"){
            return \App\Course::all();
        }
        return $this->belongsToMany('App\Course','use_cou','owner_id','course_id')->get();
    }
    /***
     * Function which checks if user is course-owner
     * @param $c_id
     */
    public function ownCourse($c_id){
        $role = $this->role->name;
        if($role == "admin"){
            return true;
        }else if($role == "student"){
            return false;
        }
        if(sizeof($this->ownCourses()->where('slug',$c_id)) > 0){
            return true;
        }
        return false;
    }
    public function ownGroup($c_id){
        $role = $this->role->name;
        if($role == "admin"){
            return true;
        }else if($role == "student"){
            return false;
        }
        if(sizeof($this->ownGroups()->where('slug',$c_id)) > 0){
            return true;
        }
        return false;
    }
}

