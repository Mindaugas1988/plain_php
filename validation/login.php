<?php
require_once("../apps/login.php");
if (isset($_POST['nick'])&& isset($_POST['password'])) {
  $nick = htmlspecialchars($_POST['nick']);
  $password = htmlspecialchars($_POST['password']);

  if (strlen(trim($nick))<=0) {
    echo "Neįrašėte slapyvardžio";
  }
  elseif (strlen(trim($password))<=0) {
    echo "Neįrašėte slaptažodžio";
  }
  else{
    $login = new Login();
    $login->login($nick,$password);
  }

}
 ?>
