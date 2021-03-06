<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizOpen extends Model
{
    protected $table = "quizes_open";
    public $timestamps = false;
    protected $primaryKey = "id_qo";
    protected $dates = ['opened_at','closing_at'];
    public function quiz(){
        return $this->belongsTo('App\Quiz','quiz_id');
    }
    public function group(){
        return $this->belongsTo('App\Group','group_id');
    }
    public function results(){
        return $this->hasMany('\App\QuizResult','open_id')->orderBy('submitted_at','asc');
    }
    public function isActive(){
        return $this->opened_at->isPast() && !$this->closing_at->isPast();
    }
    public function didSubmit(User $user){
        $r = $this->results()->where('student_id',$user->id_u);
        return $r->count() > 0;
    }
    public function getStatsForQuestion($id){

    }
}
