<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
