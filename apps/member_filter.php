<?php
require_once("mysql.php");

/**
 *
 */
class Filter
{
  public $man;
  public $woman;
  public $online;
  public $min;
  public $max;
  public $location;

  function __construct(){
    $conn = new MySQL();
    $this->connect = $conn->connect();
  }


  public function page_count(){
    if ($this->man==1 && $this->woman ==1 &&  $this->online == 1 && $this->location=="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max GROUP BY NAME DESC";
    }elseif ($this->man==1 && $this->woman ==0 &&  $this->online == 1 && $this->location=="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Vyras' GROUP BY NAME DESC";
    }elseif ($this->man==0 && $this->woman ==1 &&  $this->online == 1 && $this->location=="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Moteris' GROUP BY NAME DESC";
    }elseif ($this->man==1 && $this->woman ==1 &&  $this->online == 1 && $this->location!="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND LOCATION='$this->location' GROUP BY NAME DESC";
    }elseif ($this->man==1 && $this->woman ==0 &&  $this->online == 1 && $this->location!="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND LOCATION='$this->location' AND SEX='Vyras' GROUP BY NAME DESC";
    }elseif ($this->man==0 && $this->woman ==1 &&  $this->online == 1 && $this->location!="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND LOCATION='$this->location' AND SEX='Moteris' GROUP BY NAME DESC";
    }elseif ($this->man==1 && $this->woman ==1 &&  $this->online == 0 && $this->location=="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max GROUP BY NAME DESC";
    }elseif ($this->man==1 && $this->woman ==0 &&  $this->online == 0 && $this->location=="Nenurodyta") {
     $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Vyras' GROUP BY NAME DESC";
    }elseif ($this->man==0 && $this->woman ==1 &&  $this->online == 0 && $this->location=="Nenurodyta") {
     $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Moteris' GROUP BY NAME DESC";
    }elseif ($this->man==1 && $this->woman ==0 &&  $this->online == 0 && $this->location!="Nenurodyta") {
    $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Vyras' AND LOCATION='$this->location' GROUP BY NAME DESC";
    }elseif ($this->man==0 && $this->woman ==1 &&  $this->online == 0 && $this->location!="Nenurodyta") {
    $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Moteris' AND LOCATION='$this->location' GROUP BY NAME DESC";
    }elseif ($this->man==0 && $this->woman ==0) {
    $sql = "SELECT ID, NAME FROM users WHERE SEX='Unknown' GROUP BY NAME DESC";
    }
    //$sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max ORDER BY NAME DESC";
    $result = $this->connect->query($sql);
    $count = $result->num_rows;
    return $count;
    //$this->connect->close();
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

  public function set_filter($user,$man,$woman,$online,$min_age,$max_age,$location){
    $numb = $this->connect->query("SELECT * FROM filter_$user")->num_rows;

    if ($numb>0) {
      $sql = "UPDATE filter_$user SET MAN=?, WOMAN =?, ONLINE =?, MIN_AGE=?, MAX_AGE=?, LOCATION=?";
      //$sql = "UPDATE filter_$user SET MAN=?, WOMAN =?, ONLINE =?, MIN_AGE=?, MAX_AGE=?, LOCATION=?";
      //Įterpiam MySQL įrašymo į duombaze uzklausa
      $stmt = $this->connect->prepare($sql);
      $stmt->bind_param("iiiiis",$man,$woman,$online,$min_age,$max_age,$location);
      if ($stmt->execute()===true) {
       return TRUE;
      }else {
        return 'Error : ('. $this->connect->errno .') '. $this->connect->error;
      }

      $stmt->close();
    }else {
      $sql = "INSERT INTO filter_$user (MAN, WOMAN, ONLINE, MIN_AGE, MAX_AGE, LOCATION) VALUES (?, ?, ?, ?, ?, ?)";
      //$sql = "UPDATE filter_$user SET MAN=?, WOMAN =?, ONLINE =?, MIN_AGE=?, MAX_AGE=?, LOCATION=?";
      //Įterpiam MySQL įrašymo į duombaze uzklausa
      $stmt = $this->connect->prepare($sql);
      $stmt->bind_param("iiiiis",$man,$woman,$online,$min_age,$max_age,$location);
      if ($stmt->execute()===true) {
        return TRUE;
      }else {
        return 'Error : ('. $this->connect->errno .') '. $this->connect->error;
      }

      $stmt->close();
    }
  }

  public function get_filter($user){
    $sql = "SELECT * FROM filter_$user";
    $result = $this->connect->query($sql);
    if ($result->num_rows>0) {
      while($row = $result->fetch_assoc()) {
        $this->man = $row['MAN'];
        $this->woman =  $row['WOMAN'];
        $this->online =  $row['ONLINE'];
        $this->min =  $row['MIN_AGE'];
        $this->max =  $row['MAX_AGE'];
        $this->location= $row['LOCATION'];
      }
    }else {
      $this->man = 1;
      $this->woman = 1;
      $this->online = 1;
      $this->min = 18;
      $this->max = 99;
      $this->location="Nenurodyta";
    }

  }



  public function all_member($page){

    $limit = 10;
    if ($page==null || preg_match("/[^0-9]/",$page)) {
      $start = 0;
    }else {
      $start = ($limit*$page)-$limit;
    }

    if ($this->man==1 && $this->woman ==1 &&  $this->online == 1 && $this->location=="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==1 && $this->woman ==0 &&  $this->online == 1 && $this->location=="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Vyras' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==0 && $this->woman ==1 &&  $this->online == 1 && $this->location=="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Moteris' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==1 && $this->woman ==1 &&  $this->online == 1 && $this->location!="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND LOCATION='$this->location' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==1 && $this->woman ==0 &&  $this->online == 1 && $this->location!="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND LOCATION='$this->location' AND SEX='Vyras' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==0 && $this->woman ==1 &&  $this->online == 1 && $this->location!="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM sessions WHERE AGE BETWEEN $this->min AND $this->max AND LOCATION='$this->location' AND SEX='Moteris' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==1 && $this->woman ==1 &&  $this->online == 0 && $this->location=="Nenurodyta") {
      $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==1 && $this->woman ==0 &&  $this->online == 0 && $this->location=="Nenurodyta") {
     $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Vyras' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==0 && $this->woman ==1 &&  $this->online == 0 && $this->location=="Nenurodyta") {
     $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Moteris' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==1 && $this->woman ==0 &&  $this->online == 0 && $this->location!="Nenurodyta") {
    $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Vyras' AND LOCATION='$this->location' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==0 && $this->woman ==1 &&  $this->online == 0 && $this->location!="Nenurodyta") {
    $sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max AND SEX='Moteris' AND LOCATION='$this->location' GROUP BY NAME DESC LIMIT $start,$limit";
    }elseif ($this->man==0 && $this->woman ==0) {
    $sql = "SELECT ID, NAME FROM users WHERE SEX='Unknown' GROUP BY NAME DESC LIMIT $start,$limit";
    }


    //$sql = "SELECT ID, NAME FROM users WHERE AGE BETWEEN $this->min AND $this->max ORDER BY ID DESC LIMIT $start,$limit";



    $query = $this->connect->query($sql);
    if ($query->num_rows>0) {
      while ($row = $query->fetch_assoc()) {
        $id = $row['ID'];
        $name = $row['NAME'];
        $dir = "photos/".$id."/";
        echo  "<div>
              <a href ='profile.php?name=$name'>
              <img src='".$this->exsist($dir,$id)."' alt='photo'/>
              </a>
              <div class='opacity-photo'>
              <p><a href='profile.php?name=$name'>$name</a></p>
              </div>
             </div>";

      }
    }else {
      echo "<h5>Narių nėra</h5>";
    }
  }

  public function search_member($member){
    $member1 = "%{$member}%";
    $sql = "SELECT ID, NAME FROM users WHERE NAME LIKE ?";
    $stmt = $this->connect->prepare($sql);
    $stmt->bind_param("s",$member1);

    if ($stmt->execute()===true) {
       $stmt->bind_result($ID,$NAME);
       $stmt->store_result();
       if ($stmt->num_rows>0) {
        while ($stmt->fetch()) {
          $dir = "../photos/".$ID."/";
          echo  "<div>
                <a href ='profile.php?name=$NAME'>
                <img src='".$this->exsist($dir,$ID)."' alt='photo'/>
                </a>
                <div class='opacity-photo'>
                <p><a href='profile.php?name=$ID'>$NAME</a></p>
                </div>
               </div>";
       }
       }else {
        echo "<h5>Narių nėra</h5>";
       }
    }else {
      echo 'Error : ('. $this->connect->errno .') '. $this->connect->error;
    }
  }

}
 ?>
