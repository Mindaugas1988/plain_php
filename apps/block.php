<?php
require_once("mysql.php");


/**
 *
 */
class Block
{

   private $connect;

  function __construct()
  {
    # code...
    $conn = new MySQL();
    $this->connect = $conn->connect();
  }


  private function exsist($dir,$id){

    if (file_exists($dir)) {
      # code...
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

  public function all_count($user){
    $sql = "SELECT * FROM block_list WHERE MASTER='$user'";
    $result = $this->connect->query($sql);
    $count = $result->num_rows;
    return $count;
    //$this->connect->close();
  }

  public function block($user,$id){
    // prepare and bind
      $stmt = $this->connect->prepare("INSERT INTO block_list (MASTER,BLOCKED_ID) VALUES (?, ?)");
      $stmt->bind_param("is",$user,$id);

      if ($stmt->execute()===true) {
        echo TRUE;
      }else {
        echo "Error: ". $this->connect->error;
      }

      $this->connect->close();

  }

  public function is_block($user,$id){
    // prepare and bind
      $sql = "SELECT ID FROM block_list WHERE MASTER=? AND BLOCKED_ID=?";
      $stmt = $this->connect->prepare($sql);
      $stmt->bind_param("is",$user,$id);
      /* execute query */
      $stmt->execute();
      /* store result */
      $stmt->store_result();

      if ($stmt->num_rows>0) {
        return TRUE;
      }else {
        return FALSE;
      }
      $stmt-close();
      $this->connect->close();

  }

  public function is_you_block($id,$user,$post_id=null){
    // prepare and bind

    if ($post_id===null) {
      # code...
      $stmt = "SELECT ID FROM block_list WHERE MASTER='$id' AND BLOCKED_ID='$user'";
      $rez = $this->connect->query($stmt);

      if ($rez->num_rows>0) {
        return TRUE;
      }else {
        return FALSE;
      }

      $this->connect->close();
    }else {
      $stmt1 = "SELECT USER_ID FROM posts WHERE ID='$post_id'";
      $rez1 = $this->connect->query($stmt1);
      if ($rez1->num_rows>0) {
        $id1 = $rez1->fetch_assoc()['USER_ID'];
        $stmt = "SELECT ID FROM block_list WHERE MASTER='$id1' AND BLOCKED_ID='$user'";
        $rez = $this->connect->query($stmt);

        if ($rez->num_rows>0) {
          return TRUE;
        }else {
          return FALSE;
        }
      }else {
        return true;
      }


    }
  }

  public function unblock($user,$id){
    // prepare and bind
      $stmt = "DELETE FROM block_list WHERE MASTER='$user' AND BLOCKED_ID='$id'";
      $rez = $this->connect->query($stmt);

      if ($rez===true) {
        echo TRUE;
      }else {
        echo "Error: ". $this->connect->error;
      }

      $this->connect->close();

  }

  public function cleanAll($user_id){
    # code...
    $sql = "DELETE FROM block_list WHERE BLOCKED_ID=?";
    //Įterpiam MySQL įrašymo į duombaze uzklausa
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("i",$user_id);
    if ($stmt->execute()===true) {
      echo TRUE;
    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }

    $stmt->close();
  }

  public function show($user,$page){
    $limit = 20;
    if ($page==null|| preg_match("/[^0-9]/",$page)) {
      $start = 0;
    }else {
      $start = ($limit*$page)-$limit;
    }

    $stmt = "SELECT * FROM block_list WHERE MASTER='$user' LIMIT $start,$limit";
    $rez = $this->connect->query($stmt);

    if ($rez->num_rows>0) {
      while ($row = $rez->fetch_assoc()) {
        $BLOCKED_ID = $row['BLOCKED_ID'];
        $photos_id= $this->getID($BLOCKED_ID);
        $dir = "photos/".$photos_id."/";
        echo "<span id='$BLOCKED_ID'>
          <a href='profile.php?name=$BLOCKED_ID'><img src='".$this->exsist($dir,$photos_id)."'></a>
          <input type='button' value='Atblokuoti'/>
        </span>";
      }
    }else {
      echo "<h5 style='text-align:center;'>Nėra užblokuotų narių<h5>";
    }

    //$this->connect->close();
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
