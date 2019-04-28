<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Course;
use App\QuestionType;
use App\Option;
use App\Question;
use App\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Own\Toolkit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $isitsaved = $q->checkanswers((empty($data->answers)) ? [] : $data->answers,(int)$data->startdatetime);
        if($isitsaved != false){
            return response()->json(["response"=>200,"perc"=>$isitsaved]);
        }else{
            $res = 500;
        }

    }
    public function studentResults(){
        $user = Auth::user();
        $results = QuizResult::where('student_id',$user->id_u)->get();
        dd($results);
    }
    public function getNewQuiz($slug){
        if(Course::where('slug',$slug)->count() > 0){
            return view('Quiz/New');
        }
        abort(404);
    }
    public function postNewQuiz(Request $request, $slug){
        if(Course::where('slug',$slug)->count() < 1){
            abort(404);
        }
        $json = $request->json;
        if(empty($json)){
            abort(404);
        }
        $json = json_decode($json);
       //dd($json);
        $result = false;
        if(sizeof($json->questions) > 0 && $this->questionsOk($json->questions) && strlen($json->name)>0 && is_numeric($json->minutesAvailable) && $json->minutesAvailable > 0){
            $q = new Quiz();
            $q->name = $json->name;
            $q->minutesAvailable = $json->minutesAvailable;
            $q->isPrivate = $json->isPrivate;
            $q->randomOrder = $json->random;
            $q->course_id = Course::where('slug',$slug)->first()->id_c;
            $q->uuid = Str::uuid();
            if($q->save()){
                $cond = false;
                for($i=0;$i<sizeof($json->questions);$i++){
                    $question = new Question();
                    $question->quiz_id = $q->id_q;
                    $question->question_type_id = QuestionType::where('name',$json->questions[$i]->type)->first()->id_qt;
                    $question->question = $json->questions[$i]->question;
                    $question->isActive = true;
                    $question->order = ($json->random) ? 0 : $i;
                    if($question->save()){
                        for($j = 0; $j < sizeof($json->questions[$i]->options);$j++){
                            $o = new Option();
                            $o->question_id = $question->id_quest;
                            $o->value = $json->questions[$i]->options[$j]->text;
                            if($o->save()){
                                if($json->questions[$i]->options[$j]->isAnswer){
                                    if(DB::table('que_ans')->insert(["question_id"=>$question->id_quest,"option_id"=>$o->id_o])){
                                        $result = true;
                                    }else{
                                        echo "chyba tu";
                                    }
                                }
                            }else{
                                echo "chyba option";
                            }
                        }
                    }else{
                        echo "chyba question";
                    }
                }
            }else{
                echo "chyba quiz";
            }

        }else{
            echo "chyba celkově";
        }
        if($result){
            $request->session()->flash('success','Test byl úspěšně přidán');
            return redirect()->route('course.course',["slug"=>$slug]);
        }else{
            $request->session()->flash('danger','Chyba při přidání testu');
            return redirect()->route('quiz.newQuiz',["slug"=>$slug]);
        }
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
    private function questionsOk($questions){
        for($i = 0;$i<sizeof($questions);$i++){
            $temp = false;
            if(QuestionType::where('name',$questions[$i]->type)->count()>0){
                if(strlen($questions[$i]->question) > 0){
                    if($this->optionsOk($questions[$i]->options)){
                        $temp = true;
                    }
                }
            }
            if(!$temp){
                return false;
            }
        }
        return true;
    }
    private function optionsOk($options){
        $count = 0;
        for($i=0;$i<sizeof($options);$i++){
            if($options[$i]->isAnswer){
                $count++;
            }
            if(strlen($options[$i]->text) == 0){
                return false;
            }
        }
        return ($count >= 1);
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
