<?php
    namespace ETLAB;


    class DB{

        public function __construct()
        {
            include('db.php');
        }
        /* Rows Count */
        public static function Execute($conn,$query){

        }

        public static function ExecuteScalar($conn,$query){
            $count=mysqli_query($conn, $query);
            if(mysqli_num_rows($count)>0){
                $data=mysqli_fetch_array($count); 
                return isset($data[0])?$data[0]:false;
            }else{
                return false;
            }
        }

        public static function ExecuteScalarRow($conn,$query){
            $mysqlquery=mysqli_query($conn, $query);
            if(mysqli_num_rows($mysqlquery)>0){
                $data=mysqli_fetch_array($mysqlquery); 
                return $data;
            }else{
                return false;
            }
        }

        public static function Update($conn,$tablename,$values,$condition){

            $columnlist = [];
            foreach (array_keys($values) as $k) {
                $columnlist[]=$k."='".$values[$k]."'";
            }

            $conditionlist = [];
            foreach (array_keys($condition) as $k) {
                $conditionlist[]="".$k."='".$condition[$k]."'";
            }
            $query = "Update `$tablename` set ".implode(",", $columnlist)." where ".implode(' and ', $conditionlist)."";
            $update=mysqli_query($conn,$query);
            return $update;
        }
    }

?>