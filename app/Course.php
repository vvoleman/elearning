<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
