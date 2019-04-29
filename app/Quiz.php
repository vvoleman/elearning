<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\QuizOpen;
use App\Group;
use Illuminate\Support\Facades\DB;

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
        return $this->hasMany('\App\QuizOpen','quiz_id')->where('deleted',false)->orderBy('closing_at','asc');
    }
    public function getOpenedFor($active = true){
        if($active){
            return $this->openedFor->where('opened_at','<',Carbon::now())->where('closing_at','>',Carbon::now());
        }else{
            return $this->openedFor->where('opened_at','>=',Carbon::now())->where('closing_at','<=',Carbon::now())->orWhere('');
        }
    }
    public function maxPoints(){
        $sum = 0;
        $data = $this->questions;
        foreach($data as $d){
            $sum += DB::table('que_ans')->where('question_id',$d->id_quest)->count();
        }
        return $sum;
    }
    public function isGroupActive($group){
        try{
            return (QuizOpen::where('quiz_id',$this->id_q)->where('group_id',$group->id_g)->where('opened_at','<',Carbon::now())->where('closing_at','>',Carbon::now())->count() > 0);
        }catch(\Exception $e){
            return true;
        }
    }
    public function canAccess($user){
        $boo = false;
        if(!empty($user->inGroups)){
            $group = $user->inGroups;
            foreach($group as $g){
                $og = $g->opened_quizes;
                for($i=0;$i<sizeof($og);$i++){
                    if($og[$i]->quiz_id == $this->id_q){
                        $qr = QuizResult::where('open_id',$og[$i]->id_qo)->where('student_id',$user->id_u)->count();
                        if(($qr == 0) && $og[$i]->isActive()){
                            $boo = true;
                        }
                    }
                }
            }
        }
        return $boo;
    }
    public function saveResult($results,$startedAt,$open){
        $qr = new QuizResult();
        $qr->student_id = Auth::user()->id_u;
        $qr->open_id = $open;
        $qr->started_at = Carbon::createFromTimestamp($startedAt)->toDateTimeString();
        $qr->submitted_at = Carbon::createFromTimestamp(time())->toDateTimeString();
        $sum = 0;
        foreach($results as $r){
            $sum+=$r["result"];
        }
        $qr->percentage = floor(100/sizeof($results)*$sum*100)/100;
        $c = new Collection(["points"=>$sum]);
        $qr->context = $c->toJSON();
        if($qr->save()){
            return $qr->percentage;
        }else{
            return false;
        }
    }
    public function checkAnswers($answers,$startedAt,$open){
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
        return $this->saveResult($results,$startedAt,$open);
    }
}
