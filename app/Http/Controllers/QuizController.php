<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;
use App\Own\Toolkit;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    private $toolkit;
    public function __construct(){
        $this->toolkit = new Toolkit();
    }
    public function getQuiz(Request $request,$id){
        $q = $this->checkUUID($id);
        /*if(!$request->session()->has('quizrun') || ($id!=$request->session()->get('quizrun')) || !$q->canAccess(Auth::user()) || $request->session()->has('timestart')){
            $request->session()->flash('danger',(!$q->canAccess(Auth::user())) ? 'Test pro vás není otevřen!' : 'K testu není možno přistoupit');
            return redirect()->route('quiz.infoQuiz',["id"=>$id]);
        }*/
        $request->session()->put('timestart',time());
        $data = collect($this->toolkit->parseQuiz($q))->toJson();
        return view('Quiz/Quiz',["q"=>$q,"json"=>$data]);
    }
    public function postQuiz(Request $r,$id){ //dodělat zabezpečení
        $q = $this->checkuuid($id);
        $data = json_decode($r->data);
        dd($data);
        $isitsaved = $q->checkanswers((empty($r->data["answers"])) ? [] : $r->data["answers"],$r->data["startdatetime"]);
        if($isitsaved != false){
            return response()->json(["response"=>200,"perc"=>$isitsaved]);
        }else{
            $res = 500;
        }

    }
    public function getNewQuiz($slug){
        return view('Quiz/New');
    }
    public function getInfoQuiz($id){
        $q = $this->checkUUID($id);
        return view('Quiz/Info',["q"=>$q,"canAccess"=>$q->canAccess(Auth::user())]);
    }
    public function postInfoQuiz(Request $request,$id){
        $q = $this->checkUUID($id);
        if(!$request->session()->has('quizrun')){
            $request->session()->put('quizrun',$id);
        }
        return redirect()->route('quiz.quiz',["id"=>$id]);

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
