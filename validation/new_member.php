<?php
session_start();
require_once("../apps/user.php");
if (isset($_SESSION['user'])) {
  $user = new User();
  $user->new_member();
}
 ?>
