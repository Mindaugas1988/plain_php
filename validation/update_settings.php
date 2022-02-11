<?php
session_start();
require_once("../apps/user.php");
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['new_password']) && isset($_SESSION['user'])) {
  # code...
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $new_password = htmlspecialchars($_POST['new_password']);
  $user_id = $_SESSION['user'];
  // Remove all illegal characters from email

  if (strlen(trim($name))<=3) {
    echo "Neįrašėt slapyvardžio arba jis trumpesnis nei 4 simboliai";
  }
  elseif (strlen(trim($password))<=3) {
    echo "Neįrašėt slaptažodžio arba jis trumpesnis nei 4 simboliai";
  }
  elseif (strlen(trim($new_password))<=3) {
    echo "Neįrašėt slaptažodžio arba jis trumpesnis nei 4 simboliai";
  }
  elseif (filter_var($email,FILTER_VALIDATE_EMAIL)===false) {
    echo "Klaidingas el pašto formatas";
  }
  else {
    $user = new User();
    $user->update_settings($user_id,$name,$email,$password,$new_password);
  }
}



 ?>
