<?php
session_start();
if (isset($_SESSION['user'])) {
  require_once("../apps/visitors.php");
  $user_id = $_SESSION['user'];
  $visitors = new Visitors();
  $visitors->new_visitors_exsists($user_id);

  # code...
}
 ?>
