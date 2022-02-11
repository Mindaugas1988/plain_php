<?php
session_start();
require_once("../apps/messages.php");
if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];
  $msg = new Messages();
  echo $msg->messages_count($user_id);
}
 ?>
