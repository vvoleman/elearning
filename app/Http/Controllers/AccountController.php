<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Own\CSVFormator;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Returns list of accounts (admin)
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAccountsListAdmin(Request $request){
        $users = User::select('id_u as id','deact_reason','deact_date','firstname','surname','email','registered','last_login','roles.name')->join('roles','users.role_id','=','roles.id_r')->orderBy('id','asc');
        if(Auth::user()->hasRole('teacher')){
            $users = $users->where('role_id',1);
        }
        $users = $users->paginate(10);
        return view('Account/admin/accounts',["data"=>$users]);
    }

    /**
     * Returns account's edit form (admin)
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditAccountAdmin($id){
        $user = User::find($id);
        return view("Account/admin/accountEdit",["u" => $user,"roles" => Role::all()]);
    }

    /**
     * Saves editted account to database (admin)
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditAccountAdmin(Request $request){
        $data = $request->validate([
            'firstname' => "required",
            'surname' => "required",
            'email' => "email",
            'id_u' => "integer",
            'deactivate' => 'nullable',
            'deact_reason' => 'nullable',
            'role_id' => 'required|integer'
        ]);
        if(!empty($data["deactivate"]) && $data["deactivate"] == "true") {
            unset($data["deactivate"]);
            $data["deact_date"] = \Illuminate\Support\Facades\DB::raw("NOW()");
        }
        $user = User::find($data["id_u"]);
        if(empty($data["deactivate"]) && !empty($user->deact_date)){
            $user->deact_date = null;
            $user->deact_reason = null;
        }
        foreach ($data as $key => $val){
            $user[$key] = $val;
        }
        if($user->save()){
            $request->session()->flash('success','Zm??na prob??hla ??sp????n??!');
            return redirect()->route('admin.accounts');
        }else{
            $request->session()->flash('danger','Zm??na prob??hla ne??sp????n??!');
            return redirect()->route('admin.editAccount');
        }
    }

    /**
     * Returns activation screen for new registration
     * @param $key
     */
    public function getActivateAccount($key){
        $usr = \DB::table('users')->where('reg_token',$key)->where('password',null)->get();
        if(sizeof($usr) > 0){
            return view('Account/activate',["user"=>$usr[0]]);
        }else{
            Session::flash('danger','Tento registra??n?? kl???? neexistuje!');
            return redirect()->route('index');
        }
    }

    /**
     * Create account via activation
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postActivateAccount(Request $request){
        $data = $request->validate([
            "new_pass" => "required|min:8|max:32",
            "new_pass2" => "same:new_pass",
            "reg_token" => "required"
        ]);
        $user = User::where('reg_token',$data["reg_token"])->get()[0]->id_u;
        $user = User::find($user);
        $user->password = Hash::make($data["new_pass"]);
        $user->reg_token = null;
        $user->registered = \Illuminate\Support\Facades\DB::raw("NOW()");
        if($user->save()){
            $request->session()->flash('success','Byl jste ??sp????n?? zaregistrov??n! Nyn?? se m????ete p??ihl??sit.');
            return redirect()->route('index');
        }else{
            $request->session()->flash('danger','P??i ukl??d??n?? se vyskytly komplikace!');
            return redirect()->route('account.activate',$data["reg_token"]);
        }
    }

    /**
     * Returns view for 'Add students/users' for teachers/admins
     * @return null
     */
    public function getAddStudents(){
        $data = [];
        $data["isAdmin"] = false;
        if(\Auth::user()->hasRole('admin')){
            $data["roles"] = Role::orderBy('id_r','asc')->get();
            $data["isAdmin"] = true;
        }
        return view('Account/unpublic/add_users',$data);
    }

    /**
     * Get data from CSV file and adds students to system
     */
    public function postAddStudents(Request $request){
        $formator = new CSVFormator();
        $cols  = ["student_firstname","student_surname","student_email"];
        if(\Auth::user()->hasRole('admin')){
            $cols[] = ["student_role",false];
        }
        $plebs = $formator->csvToArray($request->file('students_file'),$cols);
        $error = [];
        if($plebs !== false){
            foreach ($plebs as $p){
                try{
                    if(empty($p["student_role"])){
                        $p["student_role"] = Role::where('name','user')->get()[0]->id_r;
                    }else{
                        $p["student_role"] = Role::where('name',$p["student_role"])->get()[0]->id_r;
                    }
                    if(!$this->registerStudent($p)){
                        if(empty($p["student_firstname"]) || empty($p["student_surname"]) || empty($p["student_email"])){
                            $error[] = "Neplatn?? ??daje - nebyla vynech??na polo??ka?";
                        }else{
                            $error[] = "U??ivatel ".$p["student_firstname"]." ".$p["student_surname"]." ji?? existuje!";
                        }
                    }
                }catch (\Exception $e) {
                    $error[] = "Probl??m se strukturou souboru - nen?? st??edn??k tam, kde b??t nem???";
                }
            }
        }else{
            $error[] = "Neplatn?? ??daje - nebyla vynech??na polo??ka?";
        }
        if(empty($error)){
            Session::flash('success','??sp????n?? p??id??no '.sizeof($plebs).' student??!');
            return redirect()->route('account.showAddUsers');
        }else{
            $string = "";
            for ($i = 0;$i<sizeof($error);$i++){
                $string.=$error[$i]."\n";
            }
            Session::flash('danger',$string);
            return redirect()->route('account.showAddUsers');
        }
    }

    /**
     * Private function for registering students
     * @param $data
     * @return bool
     */
    private function registerStudent($data){
        $role = new \App\Role();
        $student = new User();
        $student->firstname = $data["student_firstname"];
        $student->surname = $data["student_surname"];
        $student->email = $data["student_email"];
        $student->reg_token = str_random(8);
        $student->role_id = (empty($data["student_role"]))? $role->where('name','user')->get()[0]->id_r : $data["student_role"];
        try{
            if($student->save()) {
                Mail::to($student->email)->send(new \App\Mail\RegisterToken($student->reg_token));
                //dd($student->email);
                return true;
            }
        }catch(\Exception $exception){

        }
        return false;
    }

    /**
     * Get data from form and adds one student to system
     */
    public function postAddSingleStudent(Request $request){
        $data = $request->validate([
            'student_firstname' => 'required|min:2|max:40',
            'student_surname' => 'required|min:2|max:40',
            'student_email' => 'required|email'
        ]);
        if(\Auth::user()->hasRole('admin')){
            $data['student_role'] = $request->validate([
                'student_role' => 'required|numeric|min:1'
            ])['student_role'];
        }
        if($this->registerStudent($data)){
            Session::flash('success','Student byl ??sp????n?? p??id??n!');
            return redirect()->route('account.showAddUsers');
        }else{
            Session::flash('danger','P??id??n?? studenta neprob??hlo ??sp????n??!');
            return redirect()->route('account.showAddUsers');
        }
     }

    /**
     * Returns settings page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSettingsAccount(){
        return view('Account/acc_settings');
    }

    /**
     * Posts new settings to DB
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettingsAccount(Request $request){
        $data = $request->validate([
            "email" => "email|nullable|unique:users,email",
            "newpass" => "nullable|min:8|max:32",
            "newpass2" => "same:newpass",
            "password" => "required"
        ]);
        if(Hash::check($data["password"],Auth::user()->password)){
            $user = Auth::user();
            if(!empty($data["email"])){
                $old = $user->email;
                $user->email = $data["email"];
                try{
                    if($user->save()) {
                        Mail::to($user->email)->send(new \App\Mail\ChangedMail(["name" => $user->getFullname(), "old_mail" => $old,"new_mail" => $user->email]));
                        Session::flash('success','Nov?? email byl ??sp????n?? ulo??en!');
                        return redirect()->route('account.settings');
                    }
                }catch(\Exception $exception){

                }
                Session::flash('danger','P??i ukl??d??n?? se vyskytla chyba!');

            }elseif(!empty($data["newpass"]) && ($data["password"] != $data["newpass"])){
                $user->password = Hash::make($data["newpass"]);
                try{
                    if($user->save()){
                        Mail::to($user->email)->send(new \App\Mail\ChangedPassword(["name" => $user->getFullname()]));
                        Session::flash('success','Heslo bylo ??sp????n?? zm??n??no!');
                        return redirect()->route('account.settings');
                    }else{
                        dd("tu1");
                    }
                }catch(\Exception $exception){
                    dd("tu2");
                }
                Session::flash('danger','P??i ukl??d??n?? se vyskytla chyba!');
            }else{
                dd("tu3");
            }

        }else{
            Session::flash('danger','Neplatn?? heslo!');
        }
        return redirect()->route('account.settings');

    }
}
