<?php
require_once("mysql.php");
require_once("pass.php");
/**
 *
 */
 /**
  *
  */
 class Messages
 {
   private $connect;

   function __construct()
   {
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

   public function new_msg_exsists($user){
     $sql = "SELECT ID FROM messenger_$user WHERE STATUS ='NEW'";
     $result = $this->connect->query($sql);
     $count = $result->num_rows;
     if ($count>0) {
       echo TRUE;
     }else {
       echo FALSE;
     }
   }

   public function all($user){
     $sql = "SELECT * FROM (SELECT * FROM messenger_$user ORDER BY REGDATA DESC ) AS A GROUP BY ID_SENDER ORDER BY REGDATA DESC ";
     $result = $this->connect->query($sql);
     $count = $result->num_rows;
     return $count;
   }

   public function all_sent_box($user){
     $sql = "SELECT * FROM (SELECT * FROM sent_box_$user ORDER BY REGDATE DESC ) AS A GROUP BY receiverID ORDER BY REGDATE DESC ";
     $result = $this->connect->query($sql);
     $count = $result->num_rows;
     return $count;
   }

   private function send_sent_box($user_id,$id,$text,$date){
     // prepare and bind

       $sql = "SELECT NAME FROM users WHERE ID ='$id'";
       $id_name = $this->connect->query($sql)->fetch_assoc()['NAME'];

       $stmt = $this->connect->prepare("INSERT INTO sent_box_$user_id (receiverID, receiverNAME, MESSENGER,REGDATE) VALUES (?, ?, ?, ?)");
       $stmt->bind_param("ssss",$id,$id_name,$text,$date);

         if ($stmt->execute()===true) {
           echo TRUE;
         }else {
           echo "Error: ". $this->connect->error;
         }

   }

   public function send($id1,$user_id,$user_name,$text,$date){

     if (preg_match("/[^0-9]/",$id1)) {
       $id = $this->getID($id1);
     }else {
       $id = $id1;
     }



     if ($exists = $this->connect->query("SHOW TABLES LIKE 'messenger_$id'")) {

       if($exists->num_rows == 1) {
         // prepare and bind
           $stmt = $this->connect->prepare("INSERT INTO messenger_$id (ID_SENDER, SENDER_NAME, MESSENGER,REGDATA) VALUES (?, ?, ?, ?)");
           $stmt->bind_param("ssss",$user_id,$user_name,$text,$date);

             if ($stmt->execute()===true) {
               $this->send_sent_box($user_id,$id,$text,$date);
             }else {
               echo "Error:". $this->connect->error;
             }

             $this->connect->close();
       }else {
         echo "Žinutė neišsiųsta.";
       }


     }else {
       echo "Žinutė neišsiųsta.";
     }

       }

       public function show_msg($user,$page){
         $limit = 20;
         if ($page==null || preg_match("/[^0-9]/",$page)) {
           $start = 0;
         }else {
           $start = ($limit*$page)-$limit;
         }
         $sql = "SELECT * FROM (SELECT * FROM messenger_$user ORDER BY REGDATA DESC ) AS A GROUP BY ID_SENDER ORDER BY REGDATA DESC LIMIT $start,$limit";
         $result = $this->connect->query($sql);

           if ($result->num_rows > 0) {
          // output data of each row
              while($row = $result->fetch_assoc()) {
              $dir = "photos/".$row['ID_SENDER']."/";
              //$photo = scandir($dir)[2];
              $id = $row['ID'];
              $user_id = $row['ID_SENDER'];
              $nick = $row['SENDER_NAME'];
              $text = $row['MESSENGER'];
              $status = $row['STATUS'];
              $pass = new Pass($row['REGDATA']);
              $date = $pass->count();

              echo "<div class='message-from $status' id='$user_id'>
               <div class='message-author'>
               <a href='#'><img src='".$this->exsist($dir,$user_id)."' alt='photo'/></a>
               <p>$nick</p>
               <p class='date'>Prieš $date</p>
                 </div>
               <p class='message-text'>
                 $text
               </p>
               </div>";
              }
            } else {
               echo "<h5>Nėra žinučių!!!</h5>";
                   }
               //$this->connect->close();
           }


           public function show_sent_msg($user,$page){
             $limit = 20;
             if ($page==null || preg_match("/[^0-9]/",$page)) {
               $start = 0;
             }else {
               $start = ($limit*$page)-$limit;
             }
             $sql = "SELECT * FROM (SELECT * FROM sent_box_$user ORDER BY REGDATE DESC ) AS A GROUP BY receiverID ORDER BY REGDATE DESC LIMIT $start,$limit";
             $result = $this->connect->query($sql);

               if ($result->num_rows > 0) {
              // output data of each row
                  while($row = $result->fetch_assoc()) {
                  $dir = "photos/".$row['receiverID']."/";
                  //$photo = scandir($dir)[2];
                  $id = $row['ID'];
                  $user_id = $row['receiverID'];
                  $nick = $row['receiverNAME'];
                  $text = $row['MESSENGER'];
                  $pass = new Pass($row['REGDATE']);
                  $date = $pass->count();

                  echo "<div class='message-from' id='$user_id'>
                   <div class='message-author'>
                   <a href='#'><img src='".$this->exsist($dir,$user_id)."' alt='photo'/></a>
                   <p>$nick</p>
                   <p class='date'>Prieš $date</p>
                     </div>
                   <p class='message-text'>
                     $text
                   </p>
                   </div>";
                  }
                } else {
                   echo "<h5>Nėra žinučių!!!</h5>";
                       }
                   //$this->connect->close();
               }

           public function messages_count($user){
             $sql = "SELECT * FROM messenger_$user WHERE STATUS ='NEW'";
             $result = $this->connect->query($sql);
             $count = $result->num_rows;
             return $count;
           }

           public function messages_seen($user,$id){
             $sql = "UPDATE messenger_$user SET STATUS='SEEN' WHERE ID_SENDER='$id'";

             if ($this->connect->query($sql) === TRUE) {
                echo TRUE;
            } else {
                 echo "Error updating record: " . $this->connect->error;
                   }
                     $this->connect->close();
           }

           public function chat($user,$id){

             if ($exists = $this->connect->query("SHOW TABLES LIKE 'messenger_$id'")) {
                  if($exists->num_rows == 1) {

                    $sql = "SELECT ID_SENDER, SENDER_NAME,MESSENGER,REGDATA FROM messenger_$user WHERE ID_SENDER='$id'
                      UNION ALL
                           SELECT ID_SENDER, SENDER_NAME, MESSENGER,REGDATA FROM messenger_$id WHERE ID_SENDER='$user' ORDER BY REGDATA ASC LIMIT 100";
                           $result = $this->connect->query($sql);
                           if ($result->num_rows>0) {
                             while ($row = $result->fetch_assoc() ) {
                               $dir = "../photos/".$row['ID_SENDER']."/";
                               $user_id = $row['ID_SENDER'];
                               $text = $row['MESSENGER'];
                               $regdate = $row['REGDATA'];
                               $user_name = $row['SENDER_NAME'];

                               if ($user_id == $user) {
                                 echo "<div class='user1 message'>
                                   <a href='profile.php?name=$user_name'><img src='".$this->exsist($dir,$user_id)."' class='w3-circle' alt='photo'/></a>
                                   <div class='clear'></div>
                                   <p>
                                   $text
                                   </p>
                                    <span class='date'>$regdate</span>
                                 </div>";
                               }else {
                                 echo "<div class='user2 message'>
                                   <a href='profile.php?name=$user_name'><img src='".$this->exsist($dir,$user_id)."' class='w3-circle' alt='photo'/></a>
                                   <div class='clear'></div>
                                   <p>
                                   $text
                                   </p>
                                    <span class='date'>$regdate</span>
                                 </div>";
                               }


                             }
                             # code...
                           }else {
                             echo "Nėra žinučių";
                             $this->connect->close();
                           }
                  }else {
                    echo "<h4 style='font-weight:bold; text-align:center;'>Vartotojas išsiregistravo</h4>";
                    $this->connect->close();
                  }
                     }
                      else {
                        echo "<h4 style='font-weight:bold; text-align:center;'>Vartotojas išsiregistravo</h4>";
                        $this->connect->close();
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
