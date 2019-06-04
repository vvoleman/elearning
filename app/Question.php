<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $primaryKey = "id_quest";

    public function quiz(){
        return $this->belongsTo('\App\Quiz','quiz_id');
    }
    public function question_type(){
        return $this->belongsTo('\App\QuestionType','question_type_id');
    }
    public function options(){
        return $this->hasMany('\App\Option','question_id');
    }
    public function correct_opts(){
        return $this->belongsToMany('\App\Option', 'que_ans', 'question_id', 'option_id');
    }
    public function getSelectedOptionsIn($qo_id){

    }
}
