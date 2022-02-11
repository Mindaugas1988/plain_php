<?php
session_start();
require_once("../apps/visitors.php");
if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];
  $visitors = new Visitors();
  echo $visitors->visitors_count($user_id);
}
 ?>
