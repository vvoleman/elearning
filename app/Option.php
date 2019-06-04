<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $primaryKey = "id_o";
    public $timestamps = false;

    public function correct_in(){
        return $this->belongsToMany('\App\Question','que_ans','option_id','question_id');
    }
    public function choosed_in(){
        return $this->belongsToMany('App\QuizResult','res_opt','option_id','qr_id');
    }
    public function question(){
        return $this->belongsTo('App\Question','question_id');
    }
}
