<?php
require_once("mysql.php");
require_once("pass.php");
/**
 *
 */
class Chat
{

  private $connect;

  function __construct()
  {
    $conn = new MySQL();
    $this->connect = $conn->connect();
  }

  private function exsist($dir,$id){

    if (file_exists($dir)) {
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
    }else {
      return "images/no-image.png";
    }

  }


  public function all_count(){
    $sql = "SELECT ID FROM chat";
    $result = $this->connect->query($sql);
    $count = $result->num_rows;
    return $count;
    //$this->connect->close();
  }




  public function add($user_id,$user_name,$text,$user_ip){
    // prepare and bind
      $stmt = $this->connect->prepare("INSERT INTO chat (USER_ID, USER_NAME, TEXT,USER_IP) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss",$user_id,$user_name,$text,$user_ip);
      $number = $this->connect->query("SELECT ID FROM chat")->num_rows;

      $dir = "../photos/".$user_id;

      if (count(scandir($dir))<=2) {
        echo "Nesate įkėlęs jokios nuotraukos";
      }else {

         if ($number>50) {
           if($this->connect->query("DELETE FROM chat ORDER BY DATE ASC LIMIT 1")===true){
             if ($stmt->execute()===true) {
               echo TRUE;
             }else {
               echo "Error:".$this->connect->error;
             }
           }else {
             echo "Error".$this->connect->error;
           }
         }else {
           if ($stmt->execute()===true) {
             echo TRUE;
           }else {
             echo "Error:".$this->connect->error;
           }
         }
      }
      $this->connect->close();
  }

  public function show($page){
   $limit = 10;
   if ($page==null || preg_match("/[^0-9]/",$page)) {
     $start = 0;
   }else {
     $start = ($limit*$page)-$limit;
   }

   $sql = "SELECT * FROM chat ORDER BY DATE DESC LIMIT $start,$limit";
   $result = $this->connect->query($sql);

     if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
        $dir = "photos/".$row['USER_ID']."/";
        //$photo = scandir($dir)[2];
        $id = $row['ID'];
        $user_id = $row['USER_ID'];
        $nick = $row['USER_NAME'];
        $text = $row['TEXT'];
        $pass = new Pass($row['DATE']);
        $date = $pass->count();

        if ($this->is_exsists($nick)>0) {
          echo "<div class='chat'>";
          echo "<div class ='post_author'>
          <a href='profile.php?name=$nick'><img src='".$this->exsist($dir,$user_id)."' alt='images/no-image.png'/></a>
          <a href='profile.php?name=$nick'><span>$nick</span></a>
          <span class='date'>Prieš: $date</span>
          </div>
          <p>
            $text
          </p>
          <div class='clear'></div>
          </div>";
        }else {
          echo "<div class='chat'>";
          echo "<div class ='post_author'>
          <a href='profile.php?id=Vartotojas'><img src='".$this->exsist($dir,$user_id)."' alt='images/no-image.png'/></a>
          <a href='profile.php?id=Vartotojas'><span>Vartotojas</span></a>
          <span class='date'>Prieš: $date</span>
          </div>
          <p>
            $text
          </p>
          <div class='clear'></div>
          </div>";
        }


        }
      } else {
         echo "<h5>Nėra jokių pokalbių!!!</h5>";
             }


  }




  public function is_exsists($user_name){
      $sql = "SELECT NAME FROM users WHERE NAME =?";
      $stmt = $this->connect->prepare($sql);
      $stmt->bind_param("s",$user_name);
      /* execute query */
      $stmt->execute();
      /* store result */
      $stmt->store_result();

      return $stmt->num_rows;


     $stmt->close();
     $this->connect->close();
  }

}

/**
 *
 */

 ?>
