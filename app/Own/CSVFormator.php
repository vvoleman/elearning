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
                if(!empty($splited[$i])){
                    $returnAr[$columns[$i]] = $splited[$i];
                }else{
                    return false;
                }
            }
            return $returnAr;
        }
    }
?>