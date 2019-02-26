<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $primaryKey = "id_o";

    public function correct_in(){
        return $this->belongsToMany('\App\Question','que_ans','option_id','question_id');
    }
}
