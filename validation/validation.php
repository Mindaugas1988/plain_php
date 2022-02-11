<?php
require_once("../apps/user.php");
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['sex']) && isset($_POST['birth'] )) {
  # code...
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $sex = htmlspecialchars($_POST['sex']);
  $birth = htmlspecialchars($_POST['birth']);
  date_default_timezone_set("Europe/Vilnius");
  $date = date("Y-m-d H:i:s");
  // Remove all illegal characters from email

  if (strlen(trim($name))<=3) {
    echo "Neįrašėt slapyvardžio arba jis trumpesnis nei 4 simboliai";
  }
  elseif (strlen(trim($password))<=3) {
    echo "Neįrašėt slaptažodžio arba jis trumpesnis nei 4 simboliai";
  }
  elseif (filter_var($email,FILTER_VALIDATE_EMAIL)===false) {
    echo "Elektroninio pašto klaida";
  }
  else {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $user = new User();
    $user->create($name,$email,$password_hash,$sex,$birth,$date);
  }
}



 ?>
