<?php
require_once("mysql.php");
require_once("pass.php");
/**
 *
 */
class Posts
{

  private $connect;

  function __construct()
  {
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
    $sql = "SELECT ID FROM posts";
    $result = $this->connect->query($sql);
    $count = $result->num_rows;
    return $count;
    //$this->connect->close();
  }

  public function all_count_user($user){
    $sql = "SELECT ID FROM posts WHERE USER_ID ='$user'";
    $result = $this->connect->query($sql);
    $count = $result->num_rows;
    return $count;
    $this->connect->close();
  }



  public function add($user_id,$user_name,$text){
    // prepare and bind
      $stmt = $this->connect->prepare("INSERT INTO posts (USER_ID, USER_NAME, TEXT) VALUES (?, ?, ?)");
      $stmt->bind_param("sss",$user_id,$user_name,$text);

      $dir = "../photos/".$user_id;

      if (count(scandir($dir))<=2) {
        echo "Nesate įkėlęs jokios nuotraukos";
      }else {
        if ($stmt->execute()===true) {
          echo TRUE;
        }else {
          echo "Error: ". $this->connect->error;
        }
      }
      $this->connect->close();
  }

  public function show($page){
   $limit = 5;
   if ($page==null || preg_match("/[^0-9]/",$page)) {
     $start = 0;
   }else {
     $start = ($limit*$page)-$limit;
   }

   $sql = "SELECT * FROM posts ORDER BY COUNT_COMM DESC LIMIT $start,$limit";
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

          echo "<div class='post' id='$id'>";
          echo $this->check_dlt_icon($id);
          echo "<div class ='post_author'>
          <a href='profile.php?name=$nick'><img src='".$this->exsist($dir,$user_id)."' alt='images/no-image.png'/></a>
          <a href='profile.php?name=$nick'><span>$nick</span></a>
          <span class='date'>Prieš: $date</span>
          </div>
          <p>
            $text
          </p>
          <div class='clear'></div>";
          echo "<div class='comments_fields'>";
          echo "<p class='accord'></p>";
          echo "<div class='comments_in'>";
          $comments = new Comments();
          $comments->show($id);
          echo "</div>";
          echo "</div>";
          echo "<form class='w3-col s12'>
            <textarea placeholder='Rašyti komentarą...' class='post_comment'></textarea>
            <div class='error comment_error'></div>
            <input type='button' class='post_comment_btn' value='Komentuoti'/>
          </form>
          </div>";
        }
      } else {
         echo "<h5>Nėra jokių pasisakymų!!!</h5>";
             }


  }

  public function show_my($user,$page){
     $limit = 5;
    if ($page==null || preg_match("/[^0-9]/",$page)) {
      $start = 0;
    }else {
      $start = ($limit*$page)-$limit;
    }

    $sql = "SELECT * FROM posts WHERE USER_ID ='$user'  ORDER BY COUNT_COMM DESC LIMIT $start,$limit";
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

         echo "<div class='post' id='$id'>";
         echo $this->check_dlt_icon($id);
         echo "<div class ='post_author'>
         <a href='profile.php?name=$nick'><img src='".$this->exsist($dir,$user_id)."' alt='images/no-image.png'/></a>
         <a href='profile.php?name=$nick'><span>$nick</span></a>
         <span class='date'>Prieš: $date</span>
         </div>
         <p>
           $text
         </p>
         <div class='clear'></div>";
         echo "<div class='comments_fields'>";
         echo "<p class='accord'></p>";
         echo "<div class='comments_in'>";
         $comments = new Comments();
         $comments->show($id);
         echo "</div>";
         echo "</div>";
         echo "<form class='w3-col s12'>
           <textarea placeholder='Rašyti komentarą...' class='post_comment'></textarea>
           <div class='error comment_error'></div>
           <input type='button' class='post_comment_btn' value='Komentuoti'/>
         </form>
         </div>";
       }
     } else {
        echo "<h5>Nėra jokių pasisakymų!!!</h5>";
            }


  }

  private function check_dlt_icon($post_id){
    $user_id = $_SESSION['user'];
    $sql = "SELECT USER_ID FROM posts WHERE ID='$post_id'";
    $result = $this->connect->query($sql);
    $row = $result->fetch_assoc();
    $post_author = $row['USER_ID'];

    if ($user_id==$post_author) {
      return "<img class='delete_post_icon' src ='images/delete_post_icon.png' alt='delete_photo'  title='Ištrinti pasisakymą'/>";
    }else {
      return "";
    }
  }

  public function delete($post_id){
      $sql = "DELETE FROM posts WHERE ID ='$post_id'";

      if ($this->connect->query($sql) === TRUE) {
       echo $this->delete_comment($post_id);
      } else {
       echo "Error deleting record: " .$this->connect->error;
      }

     $this->connect->close();
  }

  private function delete_comment($post_id){
    $sql = "DELETE FROM comments WHERE ID_POST ='$post_id'";

    if ($this->connect->query($sql) === TRUE) {
     return TRUE;
    } else {
     return "Error deleting record: " .$this->connect->error;
    }

   $this->connect->close();
  }

  public function deleteAll($user_id){
      $sql = "DELETE FROM posts WHERE USER_ID ='$user_id'";

      if ($this->connect->query($sql) === TRUE) {
       return $this->delete_comments($user_id);
      } else {
       return "Error deleting record: " .$this->connect->error;
      }

     $this->connect->close();
  }

  private function delete_comments($user_id){
    $sql = "DELETE FROM comments WHERE USER_ID ='$user_id'";

    if ($this->connect->query($sql) === TRUE) {
     return TRUE;
    } else {
     return "Error deleting record: " .$this->connect->error;
    }

   $this->connect->close();
  }

}

/**
 *
 */
class Comments
{

  private $connect;

  function __construct()
  {
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

  private function update_posts_count($post_id){
    $stmt = $this->connect->prepare("SELECT COUNT_COMM FROM posts WHERE ID=?");
    $stmt->bind_param("i",$post_id);

    if ($stmt->execute()===true) {
      $stmt->bind_result($COUNT_COMM);
      $stmt->fetch();
      $count = $COUNT_COMM+1;
      $stmt->close();

      $sql = "UPDATE posts SET COUNT_COMM=? WHERE ID=? ";
      //Įterpiam MySQL įrašymo į duombaze uzklausa
      $stmt1 = $this->connect->prepare($sql);
      $stmt1->bind_param("ii",$count,$post_id);
      if ($stmt1->execute()===true) {
        return TRUE;
      }else {
        return 'Error : ('. $this->connect->errno .') '. $this->connect->error;
      }
    }else {
      return "Klaida nuskaitant count";
    }
  }

  public function add($user_id,$user_name,$text,$post_id,$ip){
    // prepare and bind
      $stmt = $this->connect->prepare("INSERT INTO comments (USER_ID, USER_NAME, TEXT,ID_POST,IP) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss",$user_id,$user_name,$text,$post_id,$ip);

      $dir = "../photos/".$user_id;

      if (count(scandir($dir))<=2) {
        echo "Nesate įkėlęs jokios nuotraukos";
      }else {
        if ($stmt->execute()===true) {
          echo $this->update_posts_count($post_id);
        }else {
          echo "Error: ". $this->connect->error;
        }
      }
      $this->connect->close();

  }

  public function show($post_id, $photos_dir="photos/"){
    $sql = "SELECT * FROM comments WHERE ID_POST = '$post_id' ORDER BY DATE ASC";
    $result = $this->connect->query($sql);

      if ($result->num_rows > 0) {

        //echo "<p class='accord'>Visi komentarai($result->num_rows)</p>";
     // output data of each row
         while($row = $result->fetch_assoc()) {
         $dir = $photos_dir.$row['USER_ID']."/";
         $id = $row['ID'];
         $user_id = $row['USER_ID'];
         $nick = $row['USER_NAME'];
         $text = $row['TEXT'];
         $pass = new Pass($row['DATE']);
         $date = $pass->count();
         //$photo = scandir($dir)[2];

         echo "<div class='comment'>
           <div class='comment_author'>
           <a href='profile.php?name=$nick'><img src='".$this->exsist($dir,$user_id)."' alt='images/no-image.png'/></a>
           <a href='profile.php?name=$nick'><span>$nick</span></a>
           <span class='date'>Prieš $date</span>
           </div>
           <p>
            $text
           </p>
         </div>
         <div class='clear'></div>";
         }
       } else {
          echo "";
              }
          $this->connect->close();
  }
}

 ?>
