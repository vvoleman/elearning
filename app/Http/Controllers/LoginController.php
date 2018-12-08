<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function getLogin(){
        if(Auth::check()){
            return redirect()->route('index');
        }//checks if user is not logged
        return view("login/login");
    }
    public function verifyLogin(Request $request){
        if(Auth::check()) {
            return redirect()->route('account.dashboard');
        } //checks if user is not logged
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $r = false; //remember me?
        if($request->remember==1){
            $r = true;
        }
        if (Auth::attempt($credentials,$r)){
            if(!Auth::user()->isDeactivated()){
                Auth::user()->last_login = \Illuminate\Support\Facades\DB::raw("NOW()");
                Auth::user()->save();
                Session::flash('success','Přihlášení proběhlo úspěšně!');
                //dd(Session::all());
                return redirect()->route('course.dashboard');
            }else{
                Session::flash('danger','Tento účet byl deaktivován (Důvod: '.Auth::user()->deact_reason.')');
                Auth::logout();
            }
        }else {
            Session::flash('danger','Špatné přihlašovací údaje!');
        }
        return redirect()->route('login.login');
         //checks credentials
    }
    public function getLogout(){
        Auth::logout();
        Session::flash('success','Odhlášení proběhlo úspěšně!');
        return redirect()->route('index');
    }
}