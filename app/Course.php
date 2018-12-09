<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model{
    public $timestamps = false;
    protected $primaryKey = "id_c";

    public function owners(){
        return $this->belongsToMany('App\User','use_cou','course_id','owner_id');
    }
}
