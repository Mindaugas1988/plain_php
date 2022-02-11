<?php
session_start();
if (isset($_SESSION['user'])) {
  require_once("../apps/messages.php");
  $user_id = $_SESSION['user'];
  $msg = new Messages();
  $msg->new_msg_exsists($user_id);

  # code...
}
 ?>
