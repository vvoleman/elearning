<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class CourseController extends Controller
{
    /**
     * Returns dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard(Request $request){
        $user = Group::find(1)->students[0];
        dd($user->groups);
        //return view('Course/dashboard');
    }
    public function getCoursePage($id){

    }
}
