<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Group;
use Illuminate\Support\Facades\Auth;
use App\Own\Toolkit;

class GroupController extends Controller
{
    public function getGroupPage($id){
        $group = Group::where("slug",$id)->get();
        if(sizeof($group) != 1){
            return abort(404);
        }
        $group = $group[0];
        if(!$group->canAccess(Auth::user())){
            abort(403);
        }
        $t = new Toolkit();
        return view('Group/GroupPage',["g"=>$group]);
    }
    public function getEditStudent($id){
        $group = Group::where("slug",$id)->get();
        if(sizeof($group) != 1){
            return abort(404);
        }
        $group = $group[0];
        if(Auth::user()->hasRole("user") || !$group->canAccess(Auth::user())){
            abort(403);
        }
        return view('Group/EditStudent',["g" => $this->parseGroups([$group])[0]]);
    }
    /*public function aj(Request $request){
        $data = $request->validate([
            "data" => "required",
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
            $t = new Toolkit();
            $tt = $t->getUserModels($data["data"]);
            $temp = [];
            for($i = 0; $i<sizeof($data["data"]);$i++){
                if(empty($group->students->find($tt[$i]))){
                    $group->students()->attach($tt[$i]);
                }
            }
            if($group->save()){
                $err = 200;
            }else{
                $err = 500;
            }
        }
        return response()->json(["response" => $err]);
    }*/
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
            $t = new Toolkit();
            $temp = [];
            if(empty($data["data"])){
                $group->students()->detach();
            }else{
                $group->students()->sync($t->getUserModels($data["data"]));
            }
            if($group->save()){
                $err = 200;
            }else{
                $err = 500;
            }
        }
        return response()->json(["response" => $err]);
    }
    private function parseGroups($groups){
        $temp = [];
        $t = new Toolkit();
        foreach($groups as $g){
            $temp[] = [
                "id_g" => $g->id_g,
                "name" => $g->name,
                "owner" => $t->parseUsers([$g->owner]),
                "students" => $t->parseUsers($g->students),
                "slug" => $g->slug,
                "created_at" => strtotime($g->created_at)

            ];
        }
        return $temp;
    }
}
