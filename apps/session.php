<?php
require_once("mysql.php");
class Session
{

  protected $connect;
  protected $session_id;

  function __construct()
  {
    // Start the session
    session_start();
    session_set_cookie_params(10000);
    $this->session_id = session_id();
    $conn = new MySQL();
    $this->connect = $conn->connect();
  }

  public function reset(){
    $sql = "ALTER TABLE sessions AUTO_INCREMENT = 1";
    if ($this->connect->query($sql)===TRUE) {
      echo "";
    }
    else {
      echo "Error deleting record: " . $this->connect->error;
    }
  }

  function create($id,$nick,$age,$sex,$location){
    // Set session variables
    $_SESSION["user"] = $id;
    $_SESSION["user_name"] = $nick;
    $ip = $_SERVER['REMOTE_ADDR'];
    $expire = time();

   $sql = "INSERT INTO sessions (ID,SESSION_ID,NAME,IP,EXPIRE,AGE,SEX,LOCATION)
   VALUES ('$id','$this->session_id', '$nick', '$ip','$expire','$age','$sex','$location')";

    if ($this->connect->query($sql) === TRUE) {
    $this->reset();
    echo TRUE;
     } else {
    echo "Error: " . $sql . "<br>" . $this->connect->error;
    }

     $this->connect->close();
  }

  function destroy($id){

    // sql to delete a record
     $sql = "DELETE FROM sessions WHERE SESSION_ID= '$this->session_id'";

   if ($this->connect->query($sql) === TRUE) {
    $this->reset();
   } else {
    echo "Error deleting record: " . $this->connect->error;
   }
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();

    $this->connect->close();
  }

  function __destruct(){
    $mysql = new MySQL();
    $connect = $mysql->connect();
    // Calculate what is to be deemed old
    $old = time() - 10000;
    $sql = "DELETE FROM sessions WHERE EXPIRE<'$old'";
    // Attempt execution
    if($connect->query($sql)===true){

      $alt = "ALTER TABLE sessions AUTO_INCREMENT = 1";
      if ($connect->query($alt)===TRUE) {
        // remove all session variables
      return TRUE;
      }
      else {
        return false;
      }

    }else {
      // Return False
      return false;
    }

   $connect->close();

  }

}

 ?>
