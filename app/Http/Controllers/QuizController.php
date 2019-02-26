<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;
use App\Own\Toolkit;

class QuizController extends Controller
{
    private $toolkit;
    public function __construct(){
        $this->toolkit = new Toolkit();
    }
    public function getQuiz(Request $request,$id){
       $q = $this->checkUUID($id);
       $data = collect($this->toolkit->parseQuiz($q))->toJson();
       return view('Quiz/Quiz',["q"=>$q,"json"=>$data]);
    }
    private function checkUUID($uuid){
        $q = Quiz::where('uuid',$uuid);
        if($q->count() == 1){
            return $q->get()[0];
        }elseif($q->count() > 1){
            abort(500);
        }
        abort(404);
    }
}
