<?php

namespace App\Http\Controllers;

use App\Option;
use App\Question;
use App\Quiz;
use App\Module;
use Illuminate\Http\Request;
use App\Group;
use App\Course;
use App\User;
use App\Own\Toolkit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
            $g = $user->inGroups;
        }else{
            $c = $user->ownCourses();
            $g = $user->ownGroups();
        }

        return view('Course/dashboard',["msgs_count"=>$msgs_count,"c"=>$this->limitCourseToOne($c),"groups"=>$g]);
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
        $students = 0;
        foreach($course->groups as $g){
            $students += $g->students->count();
        }
        return view('Course/Edit/EditCourse',["c"=>$course,"students" => $students]);
    }
    public function getEditLectors($id){
        $course = $this->checkIfHasPerm($id);
        $course->owners = $this->toolkit->parseUsers($course->owners);
        return view('Course/Edit/Lectors',["c"=>$course]);
    }
    public function getEditGroups($id){
        $course = $this->checkIfHasPerm($id);
        $course->groups = $this->toolkit->parseGroups($course->groups);
        return view('Course/Edit/Groups',["c"=>$course]);
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
    public function ajaxUpdate(Request $request){
        $u = Auth::user();
        if($u->role->name != "student"){
            $data = $request->validate([
                "data" => "required",
                "type" => "required"
            ]);
            $c = Course::find($data["data"]["course"]);
            if(empty($c)){
                return response()->json(["response"=>404]);
            }
            if($c->canAccess($u)){
                switch($data["type"]){
                    case "lectors":
                        $c = $this->updateTeachers($data["data"],$c);
                        break;
                    case "groups":
                        $c = $this->updateGroups($data["data"],$c);
                        break;
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
    public function ajaxGetReferencedModule(Request $request){
        $data = $request->validate([
            "course_id"=>"required|Integer"
        ]);
        return response()->json(Module::where('course_id',$data["course_id"])->get());
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
        $course = $course[0];
        if($course->canAccess(Auth::user())){
            return $course;
        }
        abort(403);
    }
    private function updateTeachers($data,$c){
        $users = $this->toolkit->getUserModels($data["items"]);
        if(empty($users)){
            $c->owners()->detach();
        }else{
            $c->owners()->sync($users);
        }
        return $c;
    }
    private function updateGroups($data,$c){
        $c->groups()->sync($this->toolkit->getUserModels($data["items"]));
        return $c;
    }
    private function limitCourseToOne($c){ //pokud jsou dva kurzy, vypíše ho jenom jednou
        $toReturn = collect();
        for($i=0;$i<sizeof($c);$i++){
            $id = $c[$i]->id_c;
            if($toReturn->filter(function($item,$key) use(&$id) {return $item->id_c == $id;})->count() == 0){
                $toReturn->push($c[$i]);
            }
        }
        return $toReturn;
    }
}
