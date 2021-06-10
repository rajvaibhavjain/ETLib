<?php
    namespace ETLAB;


    class Validate{

        public function __construct()
        {
        }
        
        public static function Mobile($mobile){
            return preg_match('/^[0-9]{10}+$/', $mobile);
        }

        public static function Email($email){
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        public static function Trim($array){
            $data=array();
            if(!empty($array)){
                foreach ($array as $key => $value) {
                    $data[$key]=trim($value);
                } 
            }
            return $data;
        }
        
        public static function Required($array){
            $data=array();
            if(!empty($array)){
                $allok=true;
                $msg=array();
                foreach ($array as $key => $value) {
                    $x=trim($value);
                    if($x!=""){
                        $data=array('response'=>true,'message'=>'All value are ok.');
                    }else{
                        $msg[]=$key." is required. \r\n";
                        $allok=false;
                    }
                } 
                if($allok!=true){
                    $data=array('response'=>false,'message'=>implode(' ',$msg));
                }
            }else{
                $data=array('response'=>false,'message'=>'Value not found.');
            }
            return $data;
        }

        
    }

?>