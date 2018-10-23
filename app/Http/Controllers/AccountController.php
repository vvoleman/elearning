<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AccountController extends Controller
{
    public function getDashboard(Request $request){
        return view('Account/dashboard');
    }
    public function getAccountsListAdmin(Request $request){
        $user = new User();
        $users = $user->select('id_u as id','deact_reason','deact_date','firstname','surname','email','registered','last_login','roles.name')->join('roles','users.role_id','=','roles.id_r')->get();

        return view('Account/accounts',["data"=>$users]);
    }
}
