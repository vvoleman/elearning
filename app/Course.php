<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;

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
    public function quizes(){
        return $this->hasMany("\App\Quiz","course_id");
    }

    public function canAccess(User $user){ //if user CAN SEE course (for example students)
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
    public function hasPerms(User $user){ //if user is allowed to make changes (teachers which owns the course)
        if(!$user->hasRole('admin')){
            if(sizeof($this->owners()->where('id_u',$user->id_u)->get()) == 0){
                return false;
            }
        }
        return true;
    }

    /**
     * Is user in the quiz more than once?
     * @param \App\User $user
     * @return boolean
     */
    public function oneStudentMoreGroups(User $user){
        $groups = DB::table('gro_cou')->join('use_gro','gro_cou.group_id','=','use_gro.group_id')->select('gro_cou.course_id')->where('use_gro.student_id','=',$user->id_u)->where('gro_cou.course_id','=',$this->id_c)->get();
        //dd(DB::table('gro_cou')->join('use_gro','gro_cou.group_id','=','use_gro.group_id')->join('users','use_gro.student_id','=','users.id_u')->select('users.email')->where('use_gro.student_id','=',$user->id_u)->where('gro_cou.course_id','=',$this->id_c)->get());
        if(sizeof($groups) > 1){
            return true;
        }
        return false;
    }
    public function getQuizes($private = false,$includeEditMode = false){
        return $this->quizes->where('isPrivate',$private);
    }
}
