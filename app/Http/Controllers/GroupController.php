<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Auth;
use App\Own\Toolkit;

class GroupController extends Controller
{
    private $t; //toolkit
    public function __construct(){
        $this->t = new Toolkit();
    }
    public function getGroupPage($id){
        $group = $this->checkIfExist($id);
        if($group === false){
            return abort(404);
        }
        if(!$group->canAccess(Auth::user())){
            abort(403);
        }
        return view('Group/GroupPage',["g"=>$group]);
    }
    public function getEditStudent($id){
        $group = $this->checkIfExist($id);
        if($group === false){
            abort(404);
        }
        if(Auth::user()->hasRole("user") || !$group->canAccess(Auth::user())){
            abort(403);
        }
        return view('Group/EditStudent',["g" => $this->parseGroups([$group])[0]]);
    }
    public function ajaxSyncStudentsInGroup(Request $request){
        $data = $request->validate([
            "data" => "nullable",
            "id" => "numeric|gt:0"
        ]);
        $user = Auth::user();
        $group = Group::find($data["id"]);
        $err = null;
        if(empty($group)){
            $err = 404;
        }
        if(($group->owner->id_u != $user->id_u) && !$user->hasRole('admin')){
            $err = 403;
        }

        if(empty($err)){
            $temp = [];
            if(empty($data["data"])){
                $group->students()->detach();
            }else{
                $group->students()->sync($this->t->getUserModels($data["data"]));
            }
            if($group->save()){
                $err = 200;
            }else{
                $err = 500;
            }
        }
        return response()->json(["response" => $err]);
    }
    public function ajaxImportStudents(Request $request){
        $data = $request->validate([
            "slug" => "required"
        ]);
        $group = $this->checkIfExist($data["slug"]);
        if($group === false){
            return response()->json(["response" => 404]);
        }
        return response()->json(["data"=>$this->t->parseUsers($group->students)]);
    }
    public function getNewGroup(){
        return view('Group/NewGroup');
    }
    private function checkIfExist($slug){
        $group = Group::where("slug",$slug)->get();
        if(sizeof($group) != 1){
            return false;
        }
        return $group[0];
    }
    private function parseGroups($groups){
        $temp = [];
        foreach($groups as $g){
            $temp[] = [
                "id_g" => $g->id_g,
                "name" => $g->name,
                "owner" => $this->t->parseUsers([$g->owner]),
                "students" => $this->t->parseUsers($g->students),
                "slug" => $g->slug,
                "created_at" => strtotime($g->created_at)

            ];
        }
        return $temp;
    }
}
