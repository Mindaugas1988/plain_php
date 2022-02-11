<?php
require_once("mysql.php");
require_once("session.php");
require_once("age.php");


/**
 *
 */
class User
{

  private $connect;
  public $name;
  public $age;
  public $body;
  public $relationship;
  public $smoke;
  public $alcohol;
  public $height;
  public $town;
  public $about;
  public $point;
  public $sex;
  public $birthday;
  public $day;
  public $month;
  public $year;
  public $email;

 function __construct(){
   $conn = new MySQL();
   $this->connect = $conn->connect();
 }

 private function exsist($dir,$id){

   if (count(scandir($dir))<=2) {
     return 'images/no-image.png';
   }else {
     $sql = "SELECT PHOTO FROM photo_$id ORDER BY ID ASC LIMIT 1";
     $query = $this->connect->query($sql);
     if ($query->num_rows>0) {
       $photo = $query->fetch_assoc()['PHOTO'];
       return $photo;
     }else {
         return 'images/no-image.png';
     }

   }
 }

 public function all_count(){
   $sql = "SELECT ID, NAME FROM users  ORDER BY NAME DESC";
   $result = $this->connect->query($sql);
   $count = $result->num_rows;
   return $count;
   //$this->connect->close();
 }

 private function createFilterTable($name, $email){
   $id_sql = "SELECT ID FROM users WHERE EMAIL='$email' AND NAME='$name'";
   $id_query = $this->connect->query($id_sql);
   $id = $id_query->fetch_assoc()['ID'];

   $sql = "CREATE TABLE filter_$id (MAN INT(1) NOT NULL DEFAULT 1 ,WOMAN INT(1) NOT NULL DEFAULT 1 ,ONLINE INT(1) NOT NULL DEFAULT 1, MIN_AGE INT(2) NOT NULL DEFAULT 18 ,MAX_AGE INT(2) NOT NULL DEFAULT 99 ,LOCATION VARCHAR(30) DEFAULT 'Nenurodyta')";

            if ($this->connect->query($sql) === TRUE) {
            return TRUE;
            } else {
            return FALSE;
            }

            $this->connect->close();
       }


 private function createMsgTable($name, $email){
   $id_sql = "SELECT ID FROM users WHERE EMAIL='$email' AND NAME='$name'";
   $id_query = $this->connect->query($id_sql);
   $id = $id_query->fetch_assoc()['ID'];

   $sql = "CREATE TABLE messenger_$id (ID INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,ID_SENDER INT(255) NOT NULL,SENDER_NAME VARCHAR(255) NOT NULL,MESSENGER TEXT ,REGDATA DATETIME DEFAULT NULL,STATUS VARCHAR(5) DEFAULT 'NEW')";

            if ($this->connect->query($sql) === TRUE) {
            return TRUE;
            } else {
            return FALSE;
            }

            $this->connect->close();
       }

       private function createSentBox($name, $email){
         $id_sql = "SELECT ID FROM users WHERE EMAIL='$email' AND NAME='$name'";
         $id_query = $this->connect->query($id_sql);
         $id = $id_query->fetch_assoc()['ID'];

         $sql = "CREATE TABLE sent_box_$id (ID INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,receiverID INT(255) NOT NULL,receiverNAME VARCHAR(255) NOT NULL,MESSENGER TEXT ,REGDATE DATETIME DEFAULT NULL)";

                  if ($this->connect->query($sql) === TRUE) {
                  return TRUE;
                  } else {
                  return FALSE;
                  }

                  $this->connect->close();
             }

       private function createPhotoTable($name, $email){
         $id_sql = "SELECT ID FROM users WHERE EMAIL='$email' AND NAME='$name'";
         $id_query = $this->connect->query($id_sql);
         $id = $id_query->fetch_assoc()['ID'];

         $sql = "CREATE TABLE photo_$id (ID INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,PHOTO VARCHAR(255) NOT NULL,DATE DATETIME DEFAULT NULL)";

                  if ($this->connect->query($sql) === TRUE) {
                  return TRUE;
                  } else {
                  return FALSE;
                  }

                  $this->connect->close();
             }


       private function createPhotoFolder($name, $email){
         $id_sql = "SELECT ID FROM users WHERE EMAIL='$email' AND NAME='$name'";
         $id_query = $this->connect->query($id_sql);
         $id = $id_query->fetch_assoc()['ID'];

         if (file_exists("../photos/$id")==TRUE) {
           return FALSE;
         }else {
           mkdir("../photos/$id");
           return TRUE;
         }

         $this->connect->close();
             }


             public function checkEmail($email){
               //Parenkama butent tam tikra eilute is duombazes
               $stmt = $this->connect->prepare("SELECT EMAIL FROM users WHERE EMAIL=?");
               $stmt->bind_param("s",$email);
               //Parenkama butent tam tikra eilute is duombazes

               if ($stmt->execute()===true) {
                 $stmt->bind_result($EMAIL);
                 $stmt->fetch();

                 if ($email!=$EMAIL) {
                   return TRUE;
                 }else {
                   return FALSE;
                 }
                 # code...
               }else {
                 return FALSE;
               }

                $this->connect->close();
             }

             public function checkName($name){
               //Parenkama butent tam tikra eilute is duombazes
               $stmt = $this->connect->prepare("SELECT NAME FROM users WHERE NAME=?");
               $stmt->bind_param("s",$name);
               //Parenkama butent tam tikra eilute is duombazes

               if ($stmt->execute()===true) {
                 $stmt->bind_result($NAME);
                 $stmt->fetch();

                 if ($name!=$NAME) {
                   return TRUE;
                 }else {
                   return FALSE;
                 }
                 # code...
               }else {
                 return FALSE;
               }

                $this->connect->close();
             }

  function create($name1,$email1,$password1,$sex1,$birth1,$date1)
  {

    $name = mysqli_real_escape_string($this->connect, $name1);
    $email = mysqli_real_escape_string($this->connect, $email1);
    $password = mysqli_real_escape_string($this->connect, $password1);
    $sex = mysqli_real_escape_string($this->connect, $sex1);
    $birth = mysqli_real_escape_string($this->connect, $birth1);
    $date = mysqli_real_escape_string($this->connect, $date1);

    $age = new Age();
    $age2 = $age->years($birth);

    //Įterpiam MySQL įrašymo į duombaze uzklausa
     $sql = "INSERT INTO users (NAME,EMAIL,PASSWORD,SEX,BIRTHDAY,REGDATE,AGE) VALUES (?, ?, ?, ?, ?, ?, ?)";
     //Įterpiam MySQL įrašymo į duombaze uzklausa
     $stmt = $this->connect->prepare($sql);
     $stmt->bind_param("ssssssi",$name,$email,$password,$sex,$birth,$date,$age2);

     //Tikrinama ar musu isrinktos eilutes egzistuoja
     if ($this->checkName($name) === FALSE) {
        echo "Toks vartotojas egzistuoja";
     }
     elseif ($this->checkEmail($email)===FALSE) {
       echo "Toks el pastas egzistuoja";
     }
     else {
       if ($stmt->execute() === TRUE) {
            if ($this->createMsgTable($name, $email)==FALSE) {
              die("Something Wrong with  Messege table!!!");
            }
            else if ($this->createSentBox($name, $email)==FALSE) {
              die("Something Wrong with sent box table table!!!");
            }
            else if($this->createPhotoFolder($name, $email)==FALSE) {
              die("Something Wrong with folder!!!");
            }elseif ($this->createPhotoTable($name, $email)==FALSE) {
              die("Something Wrong with photos table!!!");
            }elseif ($this->createFilterTable($name, $email)==FALSE) {
              die("Something Wrong with filter table!!!");
            }
            else {

              $id_sql = "SELECT ID,AGE,SEX,TOWN FROM users WHERE EMAIL='$email' AND NAME='$name'";
              $id_query = $this->connect->query($id_sql);

              while ($row = $id_query->fetch_assoc()) {
                $id = $row['ID'];
                $age_db = $row['AGE'];
                $sex = $row['SEX'];
                $location = $row['TOWN'];
              }

              //Sukuriamas sausainelio objektas
              $session = new Session();
              $session->create($id,$name,$age_db,$sex,$location);
              //Sukuriamas sausainelio objektas
            }
       } else {
       echo "Error:<br>" .$this->connect->error;
       }
     }

     $this->connect->close();
  }

  public function new_member(){
    $sql = "SELECT ID, NAME FROM users  ORDER BY REGDATE DESC LIMIT 15";
    $query = $this->connect->query($sql);
    if ($query->num_rows>0) {
      while ($row = $query->fetch_assoc()) {
        $id = $row['ID'];
        $name = $row['NAME'];
        $dir = "photos/".$id."/";
        echo  "<li><a href='profile.php?name=$name'><img style='width:64px;height:64px;'src='".$this->exsist($dir,$id)."' alt='photo'/></a></li>";
      }
    }else {
      echo "Naujų narių nėra";
    }
  }


  public function user($id){
    $age = new Age();
    $sql = "SELECT NAME,BIRTHDAY,BODY,RELATIONSHIP,SMOKE,ALCOHOL,TOWN,POINT,SEX,HEIGHT,ABOUT,AGE,EMAIL FROM users  WHERE NAME =? OR ID =?";
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("ss",$id,$id);
    /* execute query */
    $stmt->execute();
    /* store result */
    $stmt->store_result();


    if ($stmt->num_rows>0) {

      $stmt->bind_result($NAME,$BIRTHDAY,$BODY,$RELATIONSHIP,$SMOKE,$ALCOHOL,$TOWN,$POINT,$SEX,$HEIGHT,$ABOUT,$AGE,$EMAIL);
      $stmt->fetch();

      $explode =  explode("-",$BIRTHDAY);

      $this->name = $NAME;
      $this->age = $AGE;
      $this->body = $BODY;
      $this->relationship = $RELATIONSHIP;
      $this->smoke = $SMOKE;
      $this->alcohol = $ALCOHOL;
      $this->town = $TOWN;
      $this->point = $POINT;
      $this->sex = $SEX;
      $this->email = $EMAIL;


      $this->year = $explode[0];
      $this->month = $explode[1];
      $this->day = $explode[2];

      if ($HEIGHT==null) {
        $this->height = "Nenurodyta";
      }else {
        $this->height = $HEIGHT."cm.";
      }
      if ($ABOUT==null) {
        $this->about = "Nenurodyta";
      }else {
        $this->about = $ABOUT;
      }


    }else {
      //echo "Duomenų nėra";
      header("Location:no_profile.php");
    }
  }

  public function update($user_id,$town1,$about1,$birth,$height,$status,$smoke,$alcohol,$body,$reason){

    $town = mysqli_real_escape_string($this->connect, $town1);
    $about = mysqli_real_escape_string($this->connect, $about1);

    $age = new Age();
    $age2 = $age->years($birth);

    $sql = "UPDATE users SET HEIGHT=?, TOWN =?, ABOUT =?, BIRTHDAY=?, RELATIONSHIP=?, SMOKE=?, ALCOHOL=?, BODY=?, POINT=?, AGE=?  WHERE ID=? ";
    //Įterpiam MySQL įrašymo į duombaze uzklausa
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("issssssssis",$height,$town,$about,$birth,$status,$smoke,$alcohol,$body,$reason,$age2,$user_id);
    if ($stmt->execute()===true) {
      $stmt->close();

      $sql1 = "UPDATE sessions SET AGE=?, LOCATION =? WHERE ID=? ";
      //Įterpiam MySQL įrašymo į duombaze uzklausa
      $stmt1 = $this->connect->prepare($sql1);
      $stmt1->bind_param("iss",$age2,$town,$user_id);

      if ($stmt1->execute()===true) {
        echo TRUE;
      }else {
        echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
      }

    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }

    $stmt1->close();

  }

  public function update_settings($user_id,$name1,$email1,$password1,$new_password1){
    $name = mysqli_real_escape_string($this->connect, $name1);
    $email = mysqli_real_escape_string($this->connect, $email1);
    $password = mysqli_real_escape_string($this->connect, $password1);
    $new_password = mysqli_real_escape_string($this->connect, $new_password1);


    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);


    $stmt1 = $this->connect->prepare("SELECT PASSWORD FROM users WHERE ID = ?");
    $stmt2 = $this->connect->prepare("SELECT * FROM users WHERE NAME=? AND ID <>?");
    $stmt3 = $this->connect->prepare("SELECT * FROM users WHERE EMAIL=? AND ID <>?");
    $stmt1->bind_param("i",$user_id);
    $stmt2->bind_param("si",$name,$user_id);
    $stmt3->bind_param("si",$email,$user_id);


    if ($stmt1->execute()===true) {
      $stmt1->bind_result($PASSWORD);
      $stmt1->fetch();

      if (password_verify($password, $PASSWORD)===false) {
        echo "Senas slaptažodis neegzistuoja";
      }else{
       $stmt1->close();
       $stmt2->execute();
       $stmt2->store_result();

       if ($stmt2->num_rows>0) {
         echo "Toks vardas egzistuoja";
       }else {
         $stmt2->close();
         $stmt3->execute();
         $stmt3->store_result();

         if ($stmt3->num_rows>0) {
           echo "Toks El paštas egzistuoja";
         }else {
           $stmt3->close();
           $upd = "UPDATE users SET NAME=?, PASSWORD =?, EMAIL =? WHERE ID=? ";
           //Įterpiam MySQL įrašymo į duombaze uzklausa
           $stmt4 = $this->connect->prepare($upd);
           $stmt4->bind_param("sssi",$name,$password_hash,$email,$user_id);
           if ($stmt4->execute()===true) {
             $stmt4->close();

             $upd1 = "UPDATE sessions SET NAME=? WHERE ID=? ";
             $stmt5 = $this->connect->prepare($upd1);
             $stmt5->bind_param("si",$name,$user_id);

             if ($stmt5->execute()===true) {
               echo TRUE;
             }else {
               echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
             }


           }else {
             echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
           }

           $stmt5->close();

         }

       }

      }
      # code...
    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }

    $this->connect->close();

  }

  public function delete_profile($user1,$pass1){

    $user = mysqli_real_escape_string($this->connect, $user1);
    $pass = mysqli_real_escape_string($this->connect, $pass1);


   $sql = "SELECT PASSWORD FROM  users WHERE ID=?";
   $sql1 = "DELETE FROM  users WHERE ID='$user'";
   $sql2 = "DELETE FROM sessions WHERE ID= '$user'";
   $stmt = $this->connect->prepare($sql);
   $stmt->bind_param("s",$user);

   if ($stmt->execute()===true) {
     $stmt->bind_result($PASSWORD);
     $stmt->fetch();
     if (password_verify($pass, $PASSWORD)===true) {
       require_once("photos.php");
       require_once("posts.php");
       require_once("block.php");
       require_once("visitors.php");
       $photos = new Photos();
       $posts = new Posts();
       $visitor = new Visitors();
       $block = new Block();
       $stmt->close();
       $drop = "DROP TABLE IF EXISTS messenger_$user,photo_$user,sent_box_$user,filter_$user";
       if($this->connect->query($drop) === TRUE) {
         if ($posts->deleteAll($user)===false) {
           echo "Neistryne postu";
         }elseif ($visitor->cleanAll($user)===false) {
           echo "Neistryne sveciu";
         }elseif ($block->cleanAll($user)===false) {
           echo "Neistryne bloku";
         }
         elseif ($this->connect->query($sql1)===false) {
           echo "Neistryne vartotojo";
         }
         elseif ($this->connect->query($sql2)===false) {
           echo "Neistryne SESIJOS";
         }elseif ($photos->deleteAll($user)===false) {
           echo "Neistryne Nuotrukų";
         }
         else {
           // remove all session variables
           session_unset();
           // destroy the session
           //session_destroy();

           echo TRUE;
         }
          }
          else {
         echo "Error drop tables: " . $this->connect->error;
       }

     }else {
       echo "Neteisingas slaptažodis";
     }
   }
   else {
     echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
   }
  }

  public function getID($user){
    $sql = "SELECT ID FROM  users WHERE NAME=?";
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("s",$user);


    if ($stmt->execute()===true) {
      $stmt->bind_result($ID);
      $stmt->fetch();
      return $ID;
    }else {
       return FALSE;
    }
  }

}

 ?>
