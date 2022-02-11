<?php
session_start();
require_once("../apps/user.php");
if (isset($_POST['password']) && isset($_SESSION['user'])) {
  # code...
$user_id = $_SESSION['user'];
$password = $_POST['password'];

if (strlen(trim($password))<=0) {
  echo "Neįrašėte slaptažodžio";
}else {
$user = new User();
$user->delete_profile($user_id,$password);
}

}
 ?>
