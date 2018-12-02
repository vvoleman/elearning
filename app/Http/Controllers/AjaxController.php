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
        $users = $toolkit->parseUsers(User::whereRaw('CONCAT(firstname," ",surname) LIKE "%'.$r->name.'%"')->get());
        return response()->json($users);

    }
}
