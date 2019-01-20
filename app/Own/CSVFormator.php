<?php
    namespace App\Own;
    class CSVFormator{
        public function csvToArray($file,$columns){
            $file = fopen($file,"r");
            $returnArray = [];
            while(!feof($file)) {
                $returnArray[] = $this->prepareArray(fgets($file),$columns);
                if($returnArray[sizeof($returnArray)-1]==false){
                    return false;
                }
            }
            return $returnArray;
        }
        private function prepareArray($line,$columns){
            $line = preg_replace("/\r|\n/", "",$line);
            $splited = explode(";",$line);
            $returnAr = [];
            for($i = 0;$i<sizeof($columns);$i++){
                if(!is_array($columns[$i])){
                    $temp = [$columns[$i],true];
                }else{
                    $temp = $columns[$i];
                }
                if(empty($splited[$i]) && $temp[1]){
                    return false;
                }else{
                    $returnAr[$temp[0]] = htmlspecialchars((empty($splited[$i]))?"":$splited[$i]);
                }
            }
            return $returnAr;
        }
    }
?>