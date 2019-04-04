<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizOpen extends Model
{
    protected $table = "quizes_open";
    protected $dates = ['opened_at','closing_at'];
    public function quiz(){
        return $this->belongsTo('App\Quiz','quiz_id');
    }
    public function group(){
        return $this->belongsTo('App\Group','group_id');
    }
    public function isActive(){
        $this->opened_at->isPast();
        return $this->opened_at->isPast() && !$this->closing_at->isPast();
    }
}
