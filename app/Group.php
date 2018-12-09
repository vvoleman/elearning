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
        return $this->belongsToMany('App\User','use_gro','group_id','student_id')->withPivot('expirate_at');
    }
}
