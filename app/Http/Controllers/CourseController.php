<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Course;
use App\User;
use App\Own\Toolkit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    private $toolkit;
    public function __construct(){
        $this->toolkit = new Toolkit();
    }
    /**
     * Returns dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard(Request $request){
        $user = Auth::user();
        $msgs_count = $user->messages()->whereNull('mes_use.seen')->count();
        if($user->role->name == "user"){
            $c = $user->inCourses();
        }else{
            $c = $user->ownCourses();
        }
        $c->groups = $user->ownGroups();
        return view('Course/dashboard',["msgs_count"=>$msgs_count,"c"=>$c]);
    }
    public function getCoursePage($id){
        $course = $this->checkIfCanAccess($id);

        return view('Course/CoursePage',["c"=>$course]);
    }
    public function getNewCourse(){
        return view('Course/NewCourse');
    }
    public function postNewCourse(Request $request){
        $data = $request->validate([
            "name" => "required|min:4|max:32",
            "shortcut" => "required|min:4|max:8|unique:courses,slug",
            "desc" => "nullable"
        ]);
        $lectors = $this->toolkit->getUserModels(json_decode($request->lectors,true));
        if(Auth::user()->role->name != "admin"){
            $lectors[] = Auth::user()->id_u;
        }
        $course = new Course();
        $course->name = $data["name"];
        $course->desc = $data["desc"];
        $course->slug = $data["shortcut"];
        $code = 200;
        if($course->save()){
            $course->owners()->attach($lectors);
            if(!$course->save()){
                    $code = 500;
                }
        }else{
            $code = 500;
        }
        return redirect()->route('course.course',[$data["shortcut"]]);
    }
    public function getEditCourse($id){
        $course = $this->checkIfHasPerm($id);
        return view('Course/Edit/EditCourse',["c"=>$course]);
    }
    public function getEditLectors($id){
        $course = $this->checkIfHasPerm($id);
        $course->owners = $this->toolkit->parseUsers($course->owners);
        return view('Course/Edit/Lectors',["c"=>$course]);
    }
    public function getEditGroups($id){
        $course = $this->checkIfHasPerm($id);
    }
    public function getEditModules($id){

    }
    public function getEditSettings($id){
        $course = $this->checkIfHasPerm($id);
        $course->prepare = [
            "name" => $course->name,
            "slug" => $course->slug,
            "desc" => $course->desc
        ];
        return view('Course/Edit/Settings',["c"=>$course]);
    }
    public function ajaxUpdateTeachers(Request $request){
        $u = Auth::user();
        if($u->role->name != "student"){
            $data = $request->validate([
                "lectors" => "nullable",
                "course" => "required|numeric"
            ]);
            $users = $this->toolkit->getUserModels($data["lectors"]);
            $c = Course::find($data["course"]);
            if(empty($c)){
                return response()->json(["response"=>404]);
            }
            if(sizeof($c->owners()->where('id_u',$u->id_u)->get()) > 0 || $u->role->name == "admin"){
                if(empty($users)){
                    $c->owners()->detach();
                }else{
                    $c->owners()->sync($users);
                }
                if($c->save()){
                    return response()->json(["response"=>200]);
                }
                return response()->json(["response"=>500]);
            }
        }
        return response()->json(["response" => 403]);

    }
    public function postEditSettings($id,Request $request){ //při změně zkratky je nutno přenačíst na tvrdo celou stránku
        $data = $request->validate([
            "name" => "required|min:4|max:32",
            "slug" => "required|min:4|max:8",
            "desc" => "nullable"
        ]);
        $course = Course::where('slug',$id)->get();
        if(sizeof($course) > 0){
            $course = $course[0];
            $course->update($data);
            if($course->save()){
                Session::flash('success','Nastavení kurzu bylo úspěšně změněno!');
                return redirect()->route('course.editSettings',$course->slug);
            }else{
                Session::flash('danger','Při změně nastavení kurzu se vyskytla chyba');
                return redirect()->route('course.editSettings',$id);

            }
        }
    }
    public function ajaxEditSettings(Request $request){
        dd($request);
    }
    private function checkIfHasPerm($id){
        $course = Course::where("slug",$id)->get();
        if(sizeof($course) == 0 || sizeof($course) > 1){
            abort(404);
        }
        if(!Auth::user()->ownCourse($id)){
            abort(403);
        }
        return $course[0];
    }
    private function checkIfCanAccess($id){
        $course = Course::where("slug",$id)->get();
        if(sizeof($course) == 0 || sizeof($course) > 1){
            abort(404);
        }
        if(Auth::user()->ownCourse($id) || (sizeof(Auth::user()->inGroups) > 0 && Auth::user()->inGroups->courses()->where('slug',$id))){
            return $course[0];
        }
        abort(403);
    }
}
