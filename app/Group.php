<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model{
    public $timestamps = false;
    protected $primaryKey = "id_g";

    public function owner(){
        return $this->belongsTo('App\User',"owner_id");
    }
    public function students(){
        return $this->belongsToMany('App\User','use_gro','group_id','student_id')->withPivot('added');
    }
    public function courses(){
        return $this->belongsToMany('App\Course','gro_cou','group_id','course_id')->withPivot('expirate_at');
    }
    public function canAccess($user){
        if(!$user->hasRole('admin')){
            if(($user->hasRole('user') && sizeof($this->students->where('id_u',$user->id_u)) != 1) || ($user->hasRole('teacher') && $this->owner->id_u != $user->id_u)){
                return false;
            }
        }
        return true;
    }
    public function hasPerms(User $user){
        if(!$user->hasRole('admin')){
            if($this->owner()->where('id_u',$user->id_u)->count() == 0){
                return false;
            }
        }
        return true;
    }
}
