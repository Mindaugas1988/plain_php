<?php
require_once("../apps/user.php");
if (isset($_POST['text'])) {
  # code...
  $name = $_POST['text'];
  // Remove all illegal characters from email
    $user = new User();
    echo  $user->checkName($name);
}
