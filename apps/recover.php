<?php
require_once("mysql.php");



/**
 *
 */
class Recover
{
  private $connect;

  function __construct($pass,$nick,$id)
  {
    $conn = new MySQL();
    $this->connect = $conn->connect();
    $this->recover($pass,$nick,$id);
  }

  private function recover($pass1,$nick1,$id1){
    $pass = mysqli_real_escape_string($this->connect, $pass1);
    $nick = mysqli_real_escape_string($this->connect, $nick1);
    $id = mysqli_real_escape_string($this->connect, $id1);

    $password_hash = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET PASSWORD =? WHERE PASSWORD=? AND NAME=?";
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("sss",$password_hash,$id,$nick);

    if ($stmt->execute()===true) {
      echo "<p style='color:#FFFFFF; font-size:12px;margin-left:5%;'>Naujas slaptažodis sukurtas, galite jungtis :<a style='color:#EDC71E;'href ='http://tiurlys.lt/'>Jungtis</a></p>";
    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }

    $stmt->close();
    $this->connect->close();

  }
}
 ?>
