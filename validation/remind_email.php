<?php
if (isset($_POST['email'])) {
  require_once("../apps/remind.php");
  $email = htmlspecialchars($_POST['email']);

  if (filter_var($email,FILTER_VALIDATE_EMAIL)===false) {
    echo "Klaidingas el pašto formatas";
  }else {
    $remind = new Remind($email);
  }
  # code...
}
 ?>
