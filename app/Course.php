<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Course extends Model{
    public $timestamps = false;
    protected $primaryKey = "id_c";
    protected $fillable = ["name", "desc", "slug"];

    public function owners(){
        return $this->belongsToMany('App\User','use_cou','course_id','owner_id');
    }
    public function groups(){
        return $this->belongsToMany('App\Group','gro_cou','course_id','group_id')->withPivot('expirate_at');
    }
    public function modules(){
        return $this->hasMany('\App\Module','course_id');
    }

    public function canAccess(User $user){
        if(!$user->hasRole('admin')){
            if($user->hasRole('teacher')){
                return $this->owners()->where('id_u',$user->id_u)->count() > 0;
            }else{
                $groups = $this->groups;
                for($i = 0; $i < sizeof($groups); $i++){
                  if($groups[$i]->students()->where('id_u',$user->id_u)->count() > 0){
                      return true;
                  }
                }
                return false;
            }
        }
        return true;
    }
    public function hasPerms(User $user){
        if(!$user->hasRole('admin')){
            if(sizeof($this->owners()->where('id_u',$user->id_u)->get()) == 0){
                return false;
            }
        }
        return true;
    }
}
