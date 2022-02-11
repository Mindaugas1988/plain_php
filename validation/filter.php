<?php
session_start();
if (isset($_SESSION['user'])) {
  require_once("../apps/member_filter.php");
 $user = $_SESSION['user'];
 $man = $_POST['man'];
 $woman = $_POST['woman'];
 $online = $_POST['online'];
 $min_age = $_POST['min_age'];
 $max_age = $_POST['max_age'];
 $location = htmlspecialchars($_POST['location']);

 $filter = new Filter();
 echo $filter->set_filter($user,$man,$woman,$online,$min_age,$max_age,$location);

}
 ?>
