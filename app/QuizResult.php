<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $primaryKey = "id_qr";
    protected $dates = ["started_at","submitted_at"];
    protected $table = "quiz_results";
    public $timestamps = false;

    public function student(){
        return $this->belongsTo('\App\User','student_id');
    }
    public function quiz(){
        return $this->belongsTo('\App\QuizOpen','open_id');
    }
    public function answers(){
        return $this->belongsToMany('App\Option','res_opt','qr_id','option_id');
    }
    public function getPointsForQuestion($q_id){
        $temp = collect($this->answers->where("question_id",$q_id)->values());
        $ans_opt = [];
        for($i=0;$i<$temp->count();$i++){
            $ans_opt[] = $temp[$i]->id_o;
        }
        //dd($ans_opt,$this->quiz->quiz->questions->where("id_quest",$q_id)->first()->options);
        return $this->quiz->quiz->getPoints(collect($ans_opt),$this->quiz->quiz->questions->where("id_quest",$q_id)->first()->correct_opts);
    }
}
