<?php
require_once("mysql.php");

/**
 *
 */
class Remind
{

  private $connect;

  function __construct($email)
  {
    //Įterpiam MySQL prisijungim klasę
    $conn = new MySQL();
    $this->connect = $conn->connect();
    //Įterpiam MySQL prisijungim klasę
    $this->checkEmail($email);
  }

  private function checkEmail($email1){
   $email = mysqli_real_escape_string($this->connect, $email1);

    $sql ="SELECT PASSWORD,NAME FROM users WHERE EMAIL=?";
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("s",$email);

    if ($stmt->execute()===true) {
      $stmt->store_result();

      if ($stmt->num_rows==1) {
        $stmt->bind_result($PASSWORD,$NAME);
        $stmt->fetch();
        $this->sendRemind($email,$PASSWORD,$NAME);
        $stmt->close();
      }else {
        echo "Toks el paštas neegzistuoja!!!";
      }

    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }
  }

  private function sendRemind($email,$pass,$nick){
    $title = "Prisijungimo duomenys";
    $link = "http://tiurlys.lt/recover.php?id=$pass&name=$nick";
    $msg = "<html>
    <body>
    <p>Vartotojo vardas: <b>$nick</b></p>
    <p>Naujo slaptažodžio sukūrimo nuoroda: <a href='$link'>$link</a></p>
    </body>
    </html>";

    // Always set content-type when sending HTML email
     $headers = "MIME-Version: 1.0" . "\r\n";
     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    if (!mail($email,$title,$msg,$headers)) {
      echo "Klaida";
    }else {
      echo "Duomenys nusiųsti";
    }
  }
}

 ?>
