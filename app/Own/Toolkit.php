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
                    "email" => $this->protectEmail($u->email),
                    "role" => $u->role->name,
                    "me" => (\Auth::user()->id_u == $u->id_u) ? true : false
                ];
            }
            return $pass;
        }
        public function getUserModels($data,$www = "id"){
            if(empty($data)){
                return [];
            }
            $temp = [];
            foreach ($data as $d){
                $temp[] = $d[$www];
            }
            return $temp;
        }
        private function protectEmail($string){
            $parts = explode("@",$string);
            $parts[0] = $this->makeItSecret($parts[0],0);
            $parts[1] = $this->makeItSecret($parts[1],3);
            return implode("@",$parts);
        }
        private function makeItSecret($string,$offset){
            return $string[0]."xxxxx".substr($string,strlen($string)-1-$offset,strlen($string)-1);
        }
    }
?>