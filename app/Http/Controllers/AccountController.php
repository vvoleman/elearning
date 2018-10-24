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
        $users = $user->select('id_u as id','deact_reason','deact_date','firstname','surname','email','registered','last_login','roles.name')->join('roles','users.role_id','=','roles.id_r')->orderBy('id','asc')->get();

        return view('Account/admin/accounts',["data"=>$users]);
    }
    public function getEditAccountAdmin($id){
        $user = new User();
        $user = $user->find($id);
        return view("Account/admin/accountEdit",["u" => $user,"roles" => \App\Role::all()]);
    }
    public function postEditAccountAdmin(Request $request){
        $data = $request->validate([
            'firstname' => "required",
            'surname' => "required",
            'email' => "required|email",
            'id_u' => "required|integer",
            'deactivate' => 'nullable',
            'deact_reason' => 'nullable',
            'role_id' => 'required|integer'
        ]);

        if(!empty($data["deactivate"]) && $data["deactivate"] == "true") {
            unset($data["deactivate"]);
            $data["deact_date"] = \Illuminate\Support\Facades\DB::raw("NOW()");
        }
        $user = new User();
        $user = $user->find($data["id_u"]);
        if(empty($data["deactivate"]) && !empty($user->deact_date)){
            $user->deact_date = null;
            $user->deact_reason = null;
        }
        foreach ($data as $key => $val){
            $user[$key] = $val;
        }
        if($user->save()){
            $request->session()->flash('success','Změna proběhla úspěšně!');
            return redirect()->route('admin.accounts');
        }else{
            $request->session()->flash('danger','Změna proběhla neúspěšně!');
            return redirect()->route('admin.editAccount');
        }
    }
}
