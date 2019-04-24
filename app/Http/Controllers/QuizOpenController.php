<?php

namespace App\Http\Controllers;

use App\Group;
use App\Own\Toolkit;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Quiz;
use App\QuizOpen;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class QuizOpenController extends Controller
{
    public function getManager($uuid){

        $q = $this->checkQuiz($uuid);
        $this->canAccess($q,Auth::user());
        $quiz = [
            "name"=>$q->name,
            "uuid"=>$q->uuid,
            "course"=>[
                "name"=>$q->course->name,
                "slug"=>$q->course->slug
            ]
        ];
        return view('QuizOpen/QuizOpen',["q"=>$quiz,"data"=>$this->prepareQuizOpens($q->getOpenedFor())]);
    }
    private function checkQuiz($uuid){
        $q = Quiz::where('uuid',$uuid)->get();
        if($q->count() == 0){
            abort(404);
        }else if($q->count() > 1){
            abort(500);
        }
        return $q[0];

    }
    private function canAccess($q,$user){
        if(!$q->course->hasPerms($user)){
            abort(403);
        }
    }
    private function prepareQuizOpens($data){
        $return = [];
        foreach($data as $q){
            $return[] = [
                "opened_at"=>$q->opened_at->timestamp,
                "closing_at"=>$q->closing_at->timestamp,
                "group"=>[
                    "id"=>$q->group->id_g,
                    "name"=>$q->group->name,
                    "owner"=>[
                        "id"=>$q->group->owner->id_u,
                        "name"=>$q->group->owner->getFullname()
                    ]
                ]
            ];
        }
        return $return;
    }

    public function ajaxCreateOpen(Request $r){
        try{
            $data = $r->validate([
                "group" => "required|integer|exists:groups,id_g",
                "quiz" => "required|exists:quizes,uuid",
                "opened_at" => "nullable|integer",
                "closing_at" => "required|integer"
            ]);
        }catch (\Exception $e){
            return response()->json(["response" => 422]);
        }
        //////////////////////////////////////////////
        $temp = "".time();
        if($data["opened_at"] < $temp){
            $data["opened_at"] = $temp;
        }
        if($data["closing_at"] <= $temp || $data["opened_at"] > $data["closing_at"]){
            dd([$temp,$data["opened_at"],$data["closing_at"]]);
            return response()->json(["response" => 422]);
        }
        $data["closing_at"] = Carbon::createFromTimestamp($data["closing_at"]);
        $data["opened_at"] = Carbon::createFromTimestamp($data["opened_at"]);
        //////////////////////////////////////////////
        $q = Quiz::where('uuid',$data["quiz"])->get()[0];
        $this->canAccess($q,Auth::user());

        $collides = QuizOpen::where('quiz_id',$q->id_q)->where('opened_at','<',Carbon::now())->where('closing_at','>',Carbon::now())->whereBetween('opened_at',[$data["opened_at"],$data["closing_at"]])->orWhereBetween('closing_at',[$data["opened_at"],$data["closing_at"]])->get();
        if(sizeof($collides) != 0){
            $ids = [];
            foreach($collides as $c){
                $ids[] = $c->id_qo;
            }
            return response()->json(["response"=>500,"quizes"=>$ids]);
        }
        //////////////////////////////////////////////
        $qo = new QuizOpen();
        $qo->quiz_id = $q->id_q;
        $qo->group_id = $data["group"];
        $qo->opened_at = $data["opened_at"];
        $qo->closing_at = $data["closing_at"];
        if($qo->save()){
            return response()->json(["response"=>200]);
        }
    }
    public function ajaxGroupsForOpen(Request $r){
        try{
            $data = $r->validate([
                "name" => "required",
                "quiz" => "required|exists:quizes,uuid",
            ]);
        }catch(\Exception $e){
            return response()->json(["response"=>422]);
        }
        $quiz = $this->checkQuiz($data["quiz"]);
        $group = $quiz->course->groups()->where('name','like','%'.$data["name"].'%')->get();
        $return = [];
        foreach($group as $g){
            if(!$quiz->isGroupActive($g)){
                $return[] = $g;
            }
        }
        $t = new Toolkit();
        return response()->json(["data"=>$t->parseGroups($return )]);
    }
}
