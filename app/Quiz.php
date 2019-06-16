<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\QuizOpen;
use App\Group;
use Illuminate\Support\Facades\Cookie;
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
            return (QuizOpen::where('quiz_id',$this->id_q)->where('group_id',$group->id_g)->where('deleted',0)->where('opened_at','<',Carbon::now())->where('closing_at','>',Carbon::now())->count() > 0);
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
    public function saveResult($results,$open){
        if(!Cookie::has('created_quiz')){
            abort(404,'Nebylo možné nalézt potřebná data');
        }
        $id = Cookie::get('created_quiz');
        $qr = QuizResult::find($id);
        if($qr->student_id != Auth::user()->id_u || $qr->open_id != $open){
            dd(($qr->student_id != Auth::user()->id_u));
            abort(500,"Při přidávání se vyskytla chyba!");
        }
        $qr->submitted_at = Carbon::createFromTimestamp(time())->toDateTimeString();
        $sum = 0;
        foreach($results as $r){
            $sum+=$r["received_points"];
        }
        $qr->points = $sum;
        $qr->percentage = floor((100*$sum)/($this->maxPoints())*100)/100;
        if($qr->save()){
            for($i=0;$i<sizeof($results);$i++){
                $qr->answers()->attach($results[$i]["answers"]);
            }
            return true;
        }else{
            return false;
        }
    }

    public function getPoints($ans_opts,$opts){
        $points = 0;

        if($ans_opts->count() > $opts->count()){
            return 0;
        }
        for($j=0;$j<$ans_opts->count();$j++){
            if($opts->where('id_o',$ans_opts[$j])->count() == 1){
                $points++;
            }
        }
        return $points;
    }
    public function checkAnswers($answers,$startedAt,$open){
        //dodělat bodování
        $results = [];
        $answers = collect($answers);
        $questions = $this->questions;
        for($i=0;$i<$questions->count();$i++){
            $points = 0;

            if($answers->where('id',$questions[$i]->id_quest)->count() == 1){
                $opts = $questions[$i]->correct_opts;
                $ans_opts = collect($answers->where('id',$questions[$i]->id_quest)[$i]->answers);
                $points = $this->getPoints($ans_opts,$opts);
            }
            $results[] = [
                "question_id"=>$questions[$i]->id_quest,
                "answers"=>(empty($ans_opts)) ? [] : $ans_opts->toArray(),
                "received_points"=>$points
            ];
        }
        return $this->saveResult($results,$open);
    }
}
