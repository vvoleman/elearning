<?php

namespace App\Http\Controllers;

use App\QuizOpen;
use App\User;
use Carbon\Carbon;
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
        $toReturn = [
            "g" => $group
        ];
        if(Auth::user()->ownGroup($group->slug)){
            /*
             * open_id, quiz_name, course_id, opened_at, closing_at
             */
            $opens = QuizOpen::where('group_id',$group->id_g)->where('opened_at','<=',Carbon::now())->get();
            $odata = [];
            foreach($opens as $o){
                $odata[] = [
                    "id_qo"=>$o->id_qo,
                    "quiz_name"=>$o->quiz->name,
                    "course"=>[
                        "id"=>$o->quiz->course->id_c,
                        "name"=>$o->quiz->course->name
                    ],
                    "result"=>route('quiz.resultAuth',$o->id_qo),
                    "opened_at"=>date('d. m. Y H:i',$o->opened_at->timestamp),
                    "closing_at"=>date('d. m. Y H:i',$o->closing_at->timestamp),
                    "active"=>($o->opened_at->isPast() && !$o->closing_at->isPast())
                ];
            }
            $toReturn["opens"] = $odata;
        }

        return view('Group/GroupPage',$toReturn);
    }
    public function getEditStudent($id){
        $group = $this->checkIfExist($id);
        if($group === false){
            abort(404);
        }
        if(Auth::user()->hasRole("user") || !$group->hasPerms(Auth::user())){
            abort(403);
        }
        return view('Group/EditStudent',["g" => $this->parseGroupsFull([$group])[0]]);
    }
    public function getNewGroup(){
        return view('Group/NewGroup');
    }
    public function postNewGroup(Request $request){
        $data = $request->validate([
            "users" => "nullable",
            "teacher" => "nullable",
            "name" => "nullable|min:8|max:32",
            "csv" => "nullable|file|mimes:csv"
        ]);
        if(!empty($data["users"]) && !empty($data["name"]) && ((Auth::user()->hasRole('admin')) ? !empty($data["teacher"]) : true)){ //manual mode
            $data["users"] = $this->t->getUserModels(json_decode($data["users"],true));
            $data["teacher"] = (Auth::user()->hasRole('admin')) ? $this->t->getUserModels([json_decode($data["teacher"],true)[0]]) : Auth::user()->id_u;
            $group = new Group();
            $group->name = $data["name"];
            $group->owner_id = $data["teacher"][0];
            $group->slug = substr(md5(mt_rand()), 0, 8);
            if($group->save()){
                $group->students()->attach($data["users"]);
                if($group->save()){
                    $request->session()->flash('success','Třída byla úspěšně vytvořena!');
                    return redirect()->route('group.group',$group->slug);
                }

            }
            $request->session()->flash('danger','Při vytváření se vyskytla chyba');
            return redirect()->route('group.newGroup');
        }else{ //csv mode

        }

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
    public function ajaxImportStudents(Request $request){ //it just returns similar
        $data = $request->validate([
            "name" => "required"
        ]);
        $groups = $this->t->parseGroups(Group::where('name','like','%'.$data["name"].'%')->get());
        return response()->json(["data"=>$groups]);
    }
    public function ajaxStudentsByGroups(Request $request){
        $data = $request->validate([
            "groups" => "required"
        ]);
        $students = [];
        for ($i=0;$i<sizeof($data["groups"]);$i++){
            $students = $students + $this->t->parseUsers(Group::find($data["groups"][$i]["id"])->students);
        }
        if(empty($students)){
            return response()->json(["response"=>500]);
        }
        return response()->json(["data" => $students]);
    }


    private function checkIfExist($slug){
        $group = Group::where("slug",$slug)->get();
        if(sizeof($group) != 1){
            return false;
        }
        return $group[0];
    }
    private function parseGroupsFull($groups){
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
