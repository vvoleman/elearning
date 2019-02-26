<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $primaryKey = "id_q";
    public $timestamps = false;
    protected $table = "quizes";

    public function questions(){
        return $this->hasMany('\App\Question','quiz_id');
    }
    public function course(){
        return $this->belongsTo("\App\Course",'course_id');
    }
    public function referencesModule(){
        return $this->belongsTo('\App\Module','referencedModule');
    }
}
