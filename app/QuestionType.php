<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $primaryKey = "id_qt";
    public function questions(){
        return $this->hasMany('\App\Question','question_type_id');
    }
}
