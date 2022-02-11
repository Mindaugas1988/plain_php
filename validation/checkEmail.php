<?php
require_once("../apps/user.php");
if (isset($_POST['text'])) {
  # code...
  $email = $_POST['text'];
  // Remove all illegal characters from email
    $user = new User();
    echo  $user->checkEmail($email);
}
