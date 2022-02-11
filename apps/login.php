<?php
require_once("mysql.php");
require_once("session.php");

/**
 *
 */
class Login
{

  private $connect;

 function __construct(){
   $conn = new MySQL();
   $this->connect = $conn->connect();
 }

  function login($nick,$pass){
    $nick1 = mysqli_real_escape_string($this->connect, $nick);
    $pass1 = mysqli_real_escape_string($this->connect, $pass);

    $sql = "SELECT PASSWORD, NAME, STATUS FROM users WHERE NAME=?";
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("s",$nick1);


    if ($stmt->execute()===true) {
      $stmt->bind_result($PASSWORD,$NAME,$STATUS);
      $stmt->fetch();
      # code...
      if ($nick1!=$NAME || password_verify($pass1, $PASSWORD)===false || "Active"!= $STATUS ) {
        echo "Vartotojo vardas ir/arba slaptažodis neteisingi!";
      }
      else {
        $stmt->close();
        $sql1 = "SELECT ID, AGE, SEX, TOWN, BIRTHDAY FROM users WHERE NAME=?";
        $stmt1 = $this->connect->prepare($sql1);
        $stmt1->bind_param("s",$nick1);
        $stmt1->execute();
        $stmt1->bind_result($ID,$AGE,$SEX,$TOWN,$BIRTHDAY);
        $stmt1->fetch();
        $id=$ID;
        $age = $AGE;
        $sex = $SEX;
        $location = $TOWN;

        $this->check_age($AGE,$BIRTHDAY,$ID);

        //Sukuriamas sausainelio objektas
         $session = new Session();
         $session->create($id,$nick1,$age,$sex,$location);
        //Sukuriamas sausainelio objektas
      }
    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }

    $this->connect->close();
  }

  function logout($id){
    //Sukuriamas sausainelio objektas
    $session = new Session();
    $session->destroy($id);
    //Sukuriamas sausainelio objektas
  }

  private function check_age($age,$birth,$id){
    date_default_timezone_set("Europe/Vilnius");
    $now = date("Y-m-d");
    $date1=date_create($birth);
    $date2=date_create($now);
    $diff=date_diff($date1,$date2)->format("%y m.");

    if ($age<$diff) {
      $new_age = $age+1;
      $sql = "UPDATE users SET AGE=? WHERE ID=? ";
      //Įterpiam MySQL įrašymo į duombaze uzklausa
      $stmt = $this->connect->prepare($sql);
      $stmt->bind_param("ii",$new_age,$id);

     if ($stmt->execute()===true) {
       return true;
     }

    }else {
      return true;
    }    
  }

}

 ?>
