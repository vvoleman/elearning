<?php

namespace App\Http\Controllers;

use App\Course;
use App\Module;
use App\Quiz;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function getIndex()
    {
        return view('Home/index',[
            "courses"=>$this->getDesc(Course::count(),["kurz","kurzy","kurzů"]),
            "modules"=>$this->getDesc(Module::count(),["modul","moduly","modulů"]),
            "quizes"=>$this->getDesc(Quiz::count(),["test","testy","testů"]),
            "users"=>$this->getDesc(User::count(),["uživatel","uživatelé","uživatelů"])
        ]);
    }
    private function getDesc($n,$words){
        if($n==1){
            return $n." ".$words[0];
        }elseif($n > 1 && $n < 5){
            return $n." ".$words[1];
        }elseif($n >=5 || $n == 0){
            return $n." ".$words[2];
        }
    }

}
