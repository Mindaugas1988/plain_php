<?php
require_once("mysql.php");
/**
 *
 */
class Photos
{

  private $connect;

  function __construct()
  {
    $conn = new MySQL();
    $this->connect = $conn->connect();
  }

  private function reset($id){
    $sql = "ALTER TABLE photo_$id AUTO_INCREMENT = 1";
    $this->connect->query($sql);
  }

  private function insertPhoto($user_id,$target_file,$date){
    $sql = "INSERT INTO photo_$user_id (PHOTO,DATE) VALUES ('$target_file','$date')";

          if ($this->connect->query($sql) === TRUE) {
              return TRUE;
                } else {
                     return "Error: ".$this->connect->error;
                       }
                          $this->connect->close();
  }

  function upload($user_id,$files,$date){
     $path = "../photos/".$user_id."/";
     $path2 = "photos/".$user_id."/";
     $target_file = $path.$files['name'];
     $target_file2 = $path2.$files['name'];


    if (file_exists($path)===true && file_exists($target_file)!=true ) {
      if (move_uploaded_file($files["tmp_name"], $target_file)) {
        $image = imagecreatefromjpeg($target_file);
        //imagejpeg($image,$target_file);
        if (imagejpeg($image,$target_file)===TRUE) {
          echo $this->insertPhoto($user_id,$target_file2,$date);
        }else {
          echo "nepavyko sumazinti";
        }
     } else {
         echo "Kažkas nepavyko.";
     }
    }else {
       echo "Toks failas egzistuoja.";
    }
  }

  function photoAlbum($id){
    $sql = "SELECT PHOTO FROM photo_$id ORDER BY ID ASC ";
    $result = $this->connect->query($sql);
    if ($result->num_rows>0) {
      $pht = $result->fetch_assoc()['PHOTO'];

      echo"<div class='w3-third'>
          <img class = 'user_photos'src='$pht' alt='photos'/>
          <div class='opacity-photo'>
            <p class ='deletePhoto'><img src='images/rremove-icon.png'/><a href='#'>Trinti</a></p>
          </div>
          <img id ='title_accept' src='images/accept-icons.png'/>
        </div>";

       for ($i=1; $i < $result->num_rows; $i++) {
         $photo = $result->fetch_assoc()['PHOTO'];
         echo"<div class='w3-third'>
             <img class = 'user_photos'src='$photo' alt='photos'/>
             <div class='opacity-photo'>
               <p class ='makeTitlePhoto'><img src='images\photo-album-icon-png.png'/><a href='#'>Padaryti pagrindine</a></p>
               <p class ='deletePhoto'><img src='images/rremove-icon.png'/><a href='#'>Trinti</a></p>
             </div>
           </div>";
       }
    }else {
      echo "<h5>Nėra įkeltų nuotraukų.</h5>";
    }
  }


  function photoProfile($id){
    $sql = "SELECT PHOTO FROM photo_$id ORDER BY ID ASC ";
    $result = $this->connect->query($sql);
    if ($result->num_rows>0) {
       while($row = $result->fetch_assoc()) {
         $photo = $row['PHOTO'];
         echo "<img class='mySlides' src='$photo'>";
       }
    }else {
      echo "<img class='mySlides' src='images/no-image.png'>";
    }

    if ($result->num_rows>1) {
      echo '<div class="arrow" onclick="plusDivs(-1)" style="position:absolute; top:45%; left:5px;"><img src="images/arrow_l.png"></div>
      <div class="arrow" onclick="plusDivs(1)" style="position:absolute; top:45%; right:5px;"><img src="images/arrow_r.png"></div>';
    }
  }

  function changePhoto($id,$first,$last){

    $last_sql = "SELECT ID FROM photo_$id WHERE PHOTO ='$last'";
    $last_query = $this->connect->query($last_sql);
    $last_id = $last_query->fetch_assoc()['ID'];

    $sql2 = "UPDATE photo_$id SET PHOTO='$first' WHERE ID ='$last_id'";

    if ($this->connect->query($sql2) === TRUE) {
          $first_sql = "SELECT ID FROM photo_$id ORDER BY ID ASC LIMIT 1";
          $first_query = $this->connect->query($first_sql);
          $first_id = $first_query->fetch_assoc()['ID'];
          $sql1 = "UPDATE photo_$id SET PHOTO='$last' WHERE ID ='$first_id'";
          if ($this->connect->query($sql1) === TRUE) {
               echo TRUE;
           } else {
               echo "Error updating record: " . $this->connect->error;
          }
     } else {
         echo "Error updating record: " . $this->connect->error;
    }

          $this->connect->close();
  }

  public function deletePhoto($user_id,$photo){
    $photo1 = "../".$photo;

    $sql = "DELETE FROM photo_$user_id WHERE PHOTO='$photo'";

        if ($this->connect->query($sql) === TRUE) {
           $this->reset($user_id);
           if (!unlink($photo1)) {
             echo "Klaida ištrinant nuotrauką: ";
           }else {
             echo TRUE;
           }

        } else {
          echo "Klaida ištrinant nuotrauką: " . $this->connect->error;
        }

       $this->connect->close();

  }

  public function deleteAll($user_id){
  $dir = "../photos/$user_id";

  if (file_exists($dir)) {
    $scan= scandir($dir);

    if (count($scan)>2) {
      for ($i=2; $i < count($scan); $i++) {
        $file = $dir."/".$scan[$i];

       if (!unlink($file)) {
         return FALSE;
         break;
       }

      }
      if (!rmdir($dir)){
        return FALSE;
      }else {
        return TRUE;
      }
    }else {
      if (!rmdir($dir)){
        return FALSE;
      }else {
        return TRUE;
      }
    }
  }else {
    echo "Nėra tokio aplankalo!!!";
  }
  }
}

 ?>
