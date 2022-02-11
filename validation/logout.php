<?php
session_start();
require_once("../apps/login.php");
if (isset($_SESSION['user'])) {
  # code...
  $user = $_SESSION['user'];
  // Remove all illegal characters from email
  $login = new Login();
  $login->logout($user);
  header("Location:../index.php");
}else {
    header("Location:../index.php");
}
