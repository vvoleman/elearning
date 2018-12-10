<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Course;
use App\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Returns dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard(Request $request){
        $msgs_count = Auth::user()->messages()->whereNull('mes_use.seen')->count();
        return view('Course/dashboard',["msgs_count"=>$msgs_count]);
    }
    public function getCoursePage($id){
        $course = Course::find($id);
        if(empty($course)){
            abort(404);
        }
        return view('Course/CoursePage',["c"=>$course]);
    }
    public function getNewCourse(){
        return view('Course/NewCourse');
    }
}
