<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Own\Toolkit;
use App\User;

class AjaxController extends Controller
{
    public function postCheckExistingEmail(Request $request){
        $data = $request->validate([
            "email" => "required|email"
        ]);
        $ret = true;
        if(sizeof(DB::table('users')->select('email')->where('email',$data["email"])->get()) > 0){
            $ret = false;
        }
        return response()->json(["unique" => $ret,"email"=>$data["email"]]);
    }
    public function getUsersByName(Request $r){
        $toolkit = new Toolkit();
        if(empty($r->name)){
            return response()->json(["response"=>"422"]);
        }
        $users = $toolkit->parseUsers(User::whereRaw('CONCAT(firstname," ",surname) LIKE "%'.$r->name.'%" || email LIKE "%'.$r->name.'%"')->get());
        return response()->json($users);
    }
    public function getUsersByIds(Request $r){
        $toolkit = new Toolkit();
        $data = $r->ids;
        for($i=0;$i<sizeof($data);$i++){
            if(!is_numeric($data[$i]) || (intval($data[$i]) < 0)){
                return response()->json(["response"=>422]);
            }
            $data[$i] = intval($data[$i]);
        }
        try{
            $data = $toolkit->parseUsers(User::find($data));
        }catch(\Exception $e){
            $data = ["response"=>500];
        }
        return response()->json($data);
    }
    public function getCheckCourseSlug(Request $r){
        $res = \App\Course::where('slug',$r->slug)->get();
        if(sizeof($res) == 1){
            return response()->json(["used" => true]);
        }else if(sizeof($res) > 1){
            return response()->json(["response" => 500]);
        }
        return response()->json(["used" => false]);
    }
}
