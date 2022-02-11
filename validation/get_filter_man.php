<?php
session_start();
if (isset($_SESSION['user'])) {
  require_once("../apps/member_filter.php");
  $user = $_SESSION['user'];
 $filter = new Filter();
 $filter->get_filter($user);

 echo $filter->man;

}
 ?>
