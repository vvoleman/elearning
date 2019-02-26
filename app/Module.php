<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Module_context;

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
        return Module_context::find($this->context_id);
    }
    public function resources(){
        return $this->hasMany('\App\Resource','module_id');
    }
    public function belongingQuizes(){
        return $this->hasMany('\App\Quiz','referencedModule');
    }

}
