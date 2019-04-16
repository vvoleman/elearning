<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use Illuminate\Support\Facades\Auth;

class QuizOpenController extends Controller
{
    public function getManager($uuid){
        $q = $this->checkQuiz($uuid);
        $quiz = [
            "name"=>$q->name,
            "uuid"=>$q->uuid,
            "course"=>[
                "name"=>$q->course->name,
                "slug"=>$q->course->slug
            ]
        ];
        $this->canAccess($q,Auth::user());

        return view('QuizOpen/QuizOpen',["q"=>$quiz,"data"=>$this->prepareQuizOpens($q->openedFor)]);
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
                "opened_at"=>$q->opened_at,
                "closing_at"=>$q->closing_at,
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
}
