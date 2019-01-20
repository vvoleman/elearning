<?php

namespace App\Http\Controllers;

use App\Module_context;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Course;
use App\Module;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function getModule($slug,$order){
        $course = $this->checkIfCanAccess($slug);
        $module = $course->modules()->where('order',$order)->get();
        $json = $this->getCurrectJson($module);
        $module = $module[0];
        $resources = $module->resources;
        return view('Module/Module',["c" => $course,"module" => $module,"data" => ["context"=>$json,"resources"=>$resources]]);
    }
    public function getEditModule($slug,$order){
        $course = $this->checkIfCanAccess($slug);
        if(!$course->hasPerms(Auth::user())){
            abort(403);
        }
        $module = $course->modules()->where('order',$order)->get();
        $json = $this->getCurrectJson($module);
        $module = $module[0];
        $resources = $module->resources;
        return view('Module/EditModule',["c" => $course,"module" => $module,"data" => ["context"=>$json,"resources"=>$resources]]);
    }
    public function postEditModule($slug,$order,Request $request){
        $data = $request->validate([
            "json" => "required",
            "name" => "required",
            "desc" => "nullable"
        ]);
        $data["json"] = json_decode($data["json"]);
        $toSave = [
            "created_at" => time(),
            "data" => $data["json"]
        ];
        $c_id = Course::where('slug',$slug)->first()->id_c;
        $string = $this->generateJSONname($c_id,$order,$toSave["created_at"]);
        if(Storage::put($string,json_encode($toSave))){
            $module = Module::where('course_id',$c_id)->where('order',$order)->get()[0];
            $mc = new Module_context();
            $mc->src = $string;
            $mc->module_id = $module->id_m;
            if($mc->save()){
                $module->context_id = $mc->id_mc;
                $module->name = $data["name"];
                $module->desc = $data["desc"];
                if($module->save()){
                    Session::flash('success','Modul byl úspěšně upraven!');
                    return redirect()->route('course.course',$slug);
                }
            }
            Session::flash('danger','Při editaci se vyskytla chyba');
            return redirect()->route('course.course',$slug);

        }
    }
    public function getNewModule($slug){
        $course = $this->checkIfCanAccess($slug);
        if(!$course->hasPerms(Auth::user())){
            abort(403);
        }
        return view('Module/NewModule',["c"=>$course]);

    }
    public function postNewModule($slug,Request $request){
        $data = $request->validate([
            "json" => "required",
            "name" => "required",
            "desc" => "nullable"
        ]);
        $data["json"] = json_decode($data["json"]);
        $toSave = [
            "created_at" => time(),
            "data" => $data["json"]
        ];
        $c = Course::where('slug',$slug)->first();
        $last = $c->modules->last();
        $order = (empty($last)) ? 1 : $last->order+1;
        $string = $this->generateJSONname($c->id_c,$order,$toSave["created_at"]);
        if(Storage::put($string,json_encode($toSave))){
            $module = new Module();
            $module->name = $data["name"];
            $module->desc = (empty($data["desc"])) ? "" : $data["desc"];
            $module->order = $order;
            $module->course_id = $c->id_c;
            $module->save();
            $mc = new Module_context();
            $mc->src = $string;
            $mc->module_id = $module->id_m;
            if($mc->save()){
                $module->context_id = $mc->id_mc;
                if($module->save()){
                    Session::flash('success','Modul byl úspěšně vytvořen!');
                    return redirect()->route('course.course',$slug);
                }
            }
            Session::flash('danger','Při vytváření se vyskytla chyba');
            return redirect()->route('course.course',$slug);

        }
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
    private function getCurrectJson($module){
        if(sizeof($module) == 0){
            abort(404);
        }
        $module = $module[0];
        return $this->loadJSONfile($module->currentVersion()->src);
    }
    private function generateJSONname($c_id,$order,$created_at){
        return 'modules/'.$c_id.'_'.$order.'_'.$created_at.'.json';
    }
}
