<?php
require_once("mysql.php");
require_once("pass.php");

/**
 *
 */
class Visitors
{

  private $connect;
  private $date;

  function __construct()
  {
    $conn = new MySQL();
    $this->connect = $conn->connect();
    date_default_timezone_set("Europe/Vilnius");
    $date = date("Y-m-d H:i:s");
    $this->date = $date;
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

  public function new_visitors_exsists($user){
    $sql = "SELECT * FROM visitors WHERE STATUS ='NEW' AND MASTER='$user'";
    $result = $this->connect->query($sql);
    $count = $result->num_rows;
    if ($count>0) {
      echo TRUE;
    }else {
      echo FALSE;
    }
  }

  public function count($user){
    $sql = "SELECT * FROM visitors WHERE MASTER='$user'";
    $result = $this->connect->query($sql);
    $count = $result->num_rows;
    return $count;
  }

  public function visit($id,$visitor_id,$visitor_name){
    $sql ="SELECT ID FROM visitors WHERE MASTER='$id'";
    $number = $this->connect->query($sql)->num_rows;

    if ($number>50) {

      if ($this->connect->query("DELETE FROM visitors WHERE MASTER='$id' ORDER BY DATE ASC LIMIT 1")===true) {
        $this->exe($id,$visitor_id,$visitor_name);
      }else {
        echo "Error:";
      }
      # code...
    }else {
      $this->exe($id,$visitor_id,$visitor_name);
    }
  }


  private function exe($id,$visitor_id,$visitor_name){

    $sql ="SELECT ID FROM visitors WHERE VISITOR_ID='$visitor_id' AND MASTER='$id'";
    $query = $this->connect->query($sql);
    if ($query->num_rows>0) {
      # code...
      $sql1 = "UPDATE visitors SET DATE=?,STATUS='NEW' WHERE VISITOR_ID='$visitor_id' AND MASTER='$id'";
      //Įterpiam MySQL įrašymo į duombaze uzklausa
      $stmt = $this->connect->prepare($sql1);
      $stmt->bind_param("s",$this->date);
      if ($stmt->execute()===true) {
        return TRUE;
      }else {
        echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
      }

      $stmt->close();


    }else {

      // prepare and bind
        $stmt = $this->connect->prepare("INSERT INTO visitors (MASTER, VISITOR_ID,VISITOR_NAME,DATE) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss",$id,$visitor_id,$visitor_name,$this->date);

        if ($stmt->execute()===true) {
          return TRUE;
        }else {
          echo "Error: ". $this->connect->error;
        }

        $this->connect->close();

    }

  }


  public function show_visitor($user_id,$page){
    $limit = 10;
    if ($page==null || preg_match("/[^0-9]/",$page)) {
      $start = 0;
    }else {
      $start = ($limit*$page)-$limit;
    }
    $sql ="SELECT VISITOR_ID,VISITOR_NAME,DATE FROM visitors WHERE MASTER='$user_id' ORDER BY DATE DESC LIMIT $start,$limit";
    $query = $this->connect->query($sql);
    if ($query->num_rows>0) {
      echo'<a href="#" id="trash_visitor"><i class="material-icons">delete</i>Ištrinti sąrašą</a>';
      while ($row = $query->fetch_assoc()) {
        $visitor_id = $row['VISITOR_ID'];
        $visitor_name = $row['VISITOR_NAME'];
        $dir = "photos/".$visitor_id."/";
        $pass = new Pass($row['DATE']);
        $date = $pass->count();
        echo  "<div>
              <a href ='profile.php?name=$visitor_name'>
              <img src='".$this->exsist($dir,$visitor_id)."' alt='photo'/>
              </a>
              <div class='opacity-photo'>
              <p><a href='profile.php?name=$visitor_name'>$visitor_name</a></p>
              </div>
              <div class='visitor_data'>Prieš $date</div>
             </div>
             ";
      }
    }else {
      echo "<h5>Nėra svečių</h5>";
    }

    //$this->connect->close();

  }

  public function seen($user_id){
    # code...
    $sql = "UPDATE visitors SET STATUS='SEEN' WHERE MASTER=?";
    //Įterpiam MySQL įrašymo į duombaze uzklausa
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("s",$user_id);
    if ($stmt->execute()===true) {
      return TRUE;
    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }

    $stmt->close();
  }


  public function cleanVisitorsLists($user_id){
    # code...
    $sql = "DELETE FROM visitors WHERE MASTER=?";
    //Įterpiam MySQL įrašymo į duombaze uzklausa
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("s",$user_id);
    if ($stmt->execute()===true) {
      echo TRUE;
    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }

    $stmt->close();
  }

  public function visitors_count($user){
    $sql = "SELECT * FROM visitors WHERE STATUS ='NEW' AND MASTER='$user'";
    $result = $this->connect->query($sql);
    $count = $result->num_rows;
    return $count;
  }

  public function cleanAll($user_id){
    # code...
    $sql = "DELETE FROM visitors WHERE VISITOR_ID=?";
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


}

 ?>
