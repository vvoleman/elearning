<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Course;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function getModule($slug,$order){
        $course = $this->checkIfCanAccess($slug);
        $module = $course->modules()->where('order',$order)->get();
        if(sizeof($module) == 0){
            abort(404);
        }
        $module = $module[0];
        $json = $this->loadJSONfile($module->currentVersion->src);
        $resources = $module->resources;
        return view('Module/Module',["c" => $course,"module" => $module,"data" => ["context"=>$json,"resources"=>$resources]]);
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
    private function loadJSONfile($url){
        return json_decode(Storage::get($url));
    }
}
