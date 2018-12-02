<?php
namespace App\Own;
    class Toolkit{
        public function parseUsers($users){
            $pass = [];
            foreach ($users as $u){
                $pass[] = [
                    "id"=>$u->id_u,
                    "firstname" => $u->firstname,
                    "surname" => $u->surname,
                    //"email" => $u->email,
                    "role" => $u->role->name
                ];
            }
            return $pass;
        }
    }
?>