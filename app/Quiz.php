<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\QuizOpen;
use App\Group;

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
    public function openedFor(){
        return $this->hasMany('\App\QuizOpen','quiz_id');
    }
    public function canAccess($user){
        $boo = false;
        if(!empty($user->inGroups)){
            $group = $user->inGroups;
            foreach($group as $g){
                $og = $g->opened_quizes;
                for($i=0;$i<sizeof($og);$i++){
                    if($og[$i]->quiz_id == $this->id_q){
                        if($og[$i]->isActive()){
                            $boo = true;
                        }
                    }
                }
            }
        }
        return $boo;
    }
    public function saveResult($results,$startedAt){
        $qr = new QuizResult();
        $qr->student_id = Auth::user()->id_u;
        $qr->group_id = 1;
        $qr->quiz_id = $this->id_q;
        $qr->started_at = Carbon::createFromTimestamp($startedAt)->toDateTimeString();
        $qr->submitted_at = Carbon::createFromTimestamp(time())->toDateTimeString();
        $sum = 0;
        foreach($results as $r){
            $sum+=$r["result"];
        }
        $qr->percentage = floor(100/sizeof($results)*$sum*100)/100;
        $qr->context = "";
        if($qr->save()){
            return $qr->percentage;
        }else{
            return false;
        }
    }
    public function checkAnswers($answers,$startedAt){
        $results = [];
        for($i=0;$i<$this->questions->count();$i++){
            $q = $this->questions[$i];
            $good = 1;
            if(empty($answers[$i]->answer[0])){
                $good = 0;
            }else{
                foreach($q->correct_opts as $opt){
                    if($opt->id_o != $answers[$i]->answer[0]){
                        $good = 0;
                        break;
                    }
                }
            }
            $results[] = [
              "id_q" => $q->id_quest,
              "result" =>  $good
            ];

        }
        //$question = $this->questions->find($answers[0]["id"]);
        return $this->saveResult($results,$startedAt);
    }
}
