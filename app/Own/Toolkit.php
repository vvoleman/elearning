<?php
namespace App\Own;
    class Toolkit{
        /**
         * Convert User models to arrays with user info
         * @param $users
         * @return array
         */
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

        public function parseGroups($groups){
            $pass = [];
            foreach ($groups as $g){
                $pass[] = [
                    "id"=>$g->id_g,
                    "name" => $g->name,
                    "students_amount" => $g->students()->count()
                ];
            }
            return $pass;
        }

        public function parseQuiz($quiz){
            $ret = [];
            foreach($quiz->questions as $q){
                $ret[] = [
                    "id" => $q->id_quest,
                    "question" => $q->question,
                    "type" => $q->question_type->name,
                    "order" => $q->order,
                    "options" => $this->parseOptions($q->options)
                ];
            }
            $data = [
                "name" => $quiz->name,
                "course" => [
                    "name" => $quiz->course->name,
                    "url" => route('course.course',$quiz->course->slug),
                    "module" => [
                        "name" => (!empty($quiz->referencesModule)) ? $quiz->referencesModule->name : null,
                        "url" => (!empty($quiz->referencesModule)) ? route('module.module',["slug"=>$quiz->course->slug,"order"=>$quiz->referencesModule->order]) : null
                    ]
                ],
                "minutesAvailable" => $quiz->minutesAvailable,
                "randomOrder" => $quiz->randomOrder,
                "questions" => $ret
            ];
            return $data;
        }

        public function parseOptions($options){
            $ret = [];
            foreach($options as $o){
                $ret[] = [
                    "id" => $o->id_o,
                    "value" => $o->value
                ];
            }
            return $ret;
        }

        /**
         * Returns array with user IDs when parsed user array given (that array returned from above)
         * @param $data
         * @param string $www
         * @return array
         */
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
