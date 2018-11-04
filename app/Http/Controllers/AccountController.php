<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Own\CSVFormator;

class AccountController extends Controller
{
    /**
     * Returns dashboard
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboard(Request $request){
        return view('Account/dashboard');
    }

    /**
     * Returns list of accounts (admin)
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAccountsListAdmin(Request $request){
        $user = new User();
        $users = $user->select('id_u as id','deact_reason','deact_date','firstname','surname','email','registered','last_login','roles.name')->join('roles','users.role_id','=','roles.id_r')->orderBy('id','asc')->get();

        return view('Account/admin/accounts',["data"=>$users]);
    }

    /**
     * Returns account's edit form (admin)
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditAccountAdmin($id){
        $user = new User();
        $user = $user->find($id);
        return view("Account/admin/accountEdit",["u" => $user,"roles" => \App\Role::all()]);
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

    /**
     * Returns activation screen for new registration
     * @param $key
     */
    public function getActivateAccount($key){
        $usr = \DB::table('users')->where('reg_token',$key)->where('password',null)->get();
        if(sizeof($usr) > 0){
            echo "(y)";
        }else{
            echo "Neplatný kód";
        }
    }

    /**
     * Returns view for 'Add students' for teachers
     * @return null
     */
    public function getAddStudents(){
        return view('Account/unpublic/add_students');
    }

    /**
     * Get data from CSV file and adds students to system
     */
    public function postAddStudents(Request $request){
        $formator = new CSVFormator();
        $plebs = $formator->csvToArray($request->file('students_file'),["student_firstname","student_surname","student_email"]);
        $error = [];
        foreach ($plebs as $p){
            if(!$this->registerStudent($p)){
                $error[] = $p;
            }
        }
        if(empty($error)){
            Session::flash('success','Úspěšně přidáno '.sizeof($plebs).' studentů!');
            return redirect()->route('teacher.showAddStudents');
        }else{
            dd($error);
        }
    }

    /**
     * Private function for registering students
     * @param $data
     * @return bool
     */
    private function registerStudent($data){
        $role = new \App\Role();
        $role = $role->where('name','user')->get()[0]->id_r;
        $student = new User();
        $student->firstname = $data["student_firstname"];
        $student->surname = $data["student_surname"];
        $student->email = $data["student_email"];
        $student->reg_token = str_random(8);
        $student->role_id = $role;
        try{
            if($student->save()) {
                Mail::to($student->email)->send(new \App\Mail\RegisterToken($student->reg_token));
                //dd($student->email);
                return true;
            }else{
                return false;
            }

            //dd(1);
        }catch(\Exception $exception){
            dd($exception);
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
        if($this->registerStudent($data)){
            Session::flash('success','Student byl úspěšně přidán!');
            return redirect()->route('teacher.showAddStudents');
        }else{
            Session::flash('danger','Přidání studenta neproběhlo úspěšně!');
            return redirect()->route('teacher.showAddStudents');
        }
     }
}
