<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Course;
use App\QuestionType;
use App\Option;
use App\User;
use App\Question;
use App\QuizOpen;
use App\QuizResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Own\Toolkit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class QuizController extends Controller
{
    private $toolkit;
    public function __construct(){
        $this->toolkit = new Toolkit();
    }
    public function getOpenResults($open_id){
        $open = $this->checkOpen($open_id,false);
        //1. Najít všechny studenty ve třídě z openu
        //2. Najít všechny resulty k danému openu
        //3. Najít otázky k testu
        $students = $open->group->students;
        $results = QuizResult::where('open_id',$open_id)->get();
        $questions = $open->quiz->questions;
        $formated_questions = $this->parseQuestions($questions);


        //potřebuju to dostat do formátu:
        //[
        //  "question_id"=>1,
        //  "selected"=>[vybrané možnosti]
        //]
        $results_questions=[];
        foreach($students as $s){
            $temp = [

            ];
            $r = $results->where("student_id",$s->id_u);
            if(sizeof($r) > 0){
                $r = $r[0];
                $questions = [];
                foreach($r->answers as $a){
                    $temp[$a->question->id_quest][] = $a->id_o;
                    if(array_search($a->question->id_quest,$questions) == false){
                        $questions[] = $a->question->id_quest;
                    }
                }
                $tempReady = [];
                for($i=0;$i<sizeof($questions);$i++){
                    $tempReady[] = [
                        "question_id"=>$questions[$i],
                        "selected_options"=>$temp[$questions[$i]]
                    ];
                }
            }else{
                $r = null;
            }
            $results_questions[] = [
                "firstname"=>$s->firstname,
                "surname"=>$s->surname,
                "time" => ($r!=null) ? ($r->submitted_at->timestamp-$r->started_at->timestamp) : null,
                "percentage"=>($r!=null) ? $r->percentage : null,
                "answers"=>($r==null) ? [] : $tempReady
            ];
        }
        return view('Quiz/OpenResults',["results"=>$results_questions,"questions"=>$formated_questions]);
    }
    public function getQuiz(Request $request,$id,$open){
        $q = $this->checkUUID($id);
        $qo = $this->checkOpen($open);
        if(!$request->session()->has('quizrun') || ($id!=$request->session()->get('quizrun')) || !$q->canAccess(Auth::user())){
            $request->session()->flash('danger',(!$q->canAccess(Auth::user())) ? 'Test pro vás není otevřen!' : $request->session()->get('quizrun')/*'K testu není možné přistoupit!'*/);
            return redirect()->route('quiz.infoQuiz',["id"=>$id,"open_id"=>$open]);
        }
        $request->session()->forget('quizrun');
        $startDate = time();
        $qr = new QuizResult();
        $qr->open_id = $open;
        $qr->student_id = Auth::user()->id_u;
        $qr->started_at = Carbon::createFromTimestamp($startDate)->toDateTimeString();
        if(!$qr->save()){
            abort(500,"Nastala chyba při inicializaci testu!");
        }
        Cookie::queue('created_quiz',$qr->id_qr,$q->minutesAvailable+5);
        $data = collect($this->toolkit->parseQuiz($q,$open));
        $data["startDate"] = $startDate;
        $data = $data->toJson();
        return view('Quiz/Quiz',["q"=>$q,"json"=>$data]);
    }
    public function postQuiz(Request $r,$id,$open){ //dodělat zabezpečení
        $q = $this->checkuuid($id);
        $qo = $this->checkOpen($open);
        $data = json_decode($r->data);
        $isitsaved = $q->checkanswers((empty($data->answers)) ? [] : $data->answers,(int)($data->startdatetime/1000),$open);
        if($isitsaved != false){
            return redirect()->route('quiz.getQuizResult',["open_id"=>$open])->withCookie(Cookie::forget('created_quiz'));
        }else{
            abort(500,"Something went kuku");
        }

    }
    public function studentResults(){
        $user = Auth::user();
        $results = QuizResult::where('submitted_at','!=',null)->where('student_id',$user->id_u)->get();
        return view('Quiz/Resultlist',["results"=>$results]);
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
    public function getInfoQuiz($id,$qo){
        $q = $this->checkUUID($id);
        Cookie::forget('created_quiz');

        $open = $this->checkOpen($qo);
        return view('Quiz/Info',["q"=>$q,"canAccess"=>$q->canAccess(Auth::user()),"open"=>$open]);
    }
    public function postInfoQuiz(Request $request,$id,$open){
        $q = $this->checkUUID($id);
        $qo = $this->checkOpen($open);
        $request->session()->put('quizrun',$id);
        return redirect()->route('quiz.quiz',["id"=>$id,"open"=>$open]);

    }
    public function getQuizResult($open){
        $open = $this->checkOpen($open,false);
        if(Auth::user()->role->name != "user"){
            $get = Input::get('user_id');
            if(!empty($get)){
                $usr = User::where('id_u',$get);
                if($usr->count() > 0){
                    $user = User::find($get);
                }else{
                    abort(404);
                }
            }else{
                abort(404);
            }
        }else{
            $user = Auth::user();
        }
        $r = QuizResult::where('open_id',$open->id_qo)->where('student_id',$user->id_u)->get();
        if($r->count() == 0){
            return view('Quiz/ResultNotFound',["user" => $user]);
        }
        return view('Quiz/Result',["result"=>$r[0],"o"=>$open]);
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
    private function checkOpen($id,$active = true){
        $open = QuizOpen::where('id_qo',$id)->get();
        if(sizeof($open) == 0){
            abort(404);
        }
        $open = $open[0];
        if($active){
            if(!$open->isActive()){
                abort(404);
            }
        }
        return $open;
    }
    private function parseQuestions($questions){
        $toReturn = [];
        foreach($questions as $q){
            $temp = [
                "question_id"=>$q->id_quest,
                "text"=>$q->question,
                "type"=>$q->question_type->name,
                "options"=>[],
                "correct_opts"=>[]
            ];
            foreach($q->options as $o){
                $temp["options"][] = [
                    "option_id"=>$o->id_o,
                    "text"=>$o->value
                ];
            }
            foreach($q->correct_opts as $c){
                $temp["correct_opts"][] = $c->id_o;
            }
            $toReturn[] = $temp;
        }
        return $toReturn;
    }
}
