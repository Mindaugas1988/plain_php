<?php
require_once("config/config.php");
class MySQL {

public function connect(){
   $connect = new mysqli(SERVERNAME,USERNAME,PASSWORD,DB);
   if ($connect->connect_error) {
     die("Database connect error ". $connect->connect_error);
   }else {
     return $connect;
   }
  }
}
 ?>
