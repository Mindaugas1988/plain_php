<?php
session_start();
require_once("../apps/messages.php");
if (isset($_SESSION['user']) && isset($_POST['id'])) {
  $user_id = $_SESSION['user'];
  $id = $_POST['id'];

  if ($id == null || $id =="") {
    echo 'Klaida';
  }else {
    $msg = new Messages();
    $msg->chat($user_id,$id);
  }

}
 ?>
