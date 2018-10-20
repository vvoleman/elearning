<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AccountController extends Controller
{
    public function getDashboard(Request $request){
        if($request->user()->hasRole('admin')){
            $user = new User();
            $users = $user->select('id_u as id','firstname','surname','email','registered','last_login','roles.name')->join('roles','users.role_id','=','roles.id_r')->get();

            return view('Account/dashboard',["data"=>$users]);
        }else{
            return view('Account/dashboard');
        }
    }
}
