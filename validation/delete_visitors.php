<?php
session_start();
require_once("../apps/visitors.php");
if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];
  $visitors = new Visitors();
  $visitors->cleanVisitorsLists($user_id);
  # code...
}
 ?>
