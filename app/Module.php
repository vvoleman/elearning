<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $primaryKey = "id_m";

    public function course(){
        return $this->belongsTo('\App\Course','course_id');
    }
    public function versions(){
        return $this->hasMany('\App\Module_context','module_id');
    }
    public function currentVersion(){
        return $this->hasOne('\App\Module_context','module_id','context_id');
    }
    public function resources(){
        return $this->hasMany('\App\Resource','module_id');
    }

}
