<?php
session_start();
require_once("../apps/user.php");
if (isset($_POST['town']) && isset($_POST['about']) && isset($_SESSION['user']) && isset($_POST['birth'])) {
  # code...
  $town = htmlspecialchars($_POST['town']);
  $about = htmlspecialchars($_POST['about']);
  $user_id = htmlspecialchars($_SESSION['user']);
  $birth = htmlspecialchars($_POST['birth']);
  $height = htmlspecialchars($_POST['height']);
  $status = htmlspecialchars($_POST['status']);
  $smoke = htmlspecialchars($_POST['smoke']);
  $alcohol = htmlspecialchars($_POST['alcohol']);
  $body = htmlspecialchars($_POST['body']);
  $reason = htmlspecialchars($_POST['reason']);

  if (strlen(trim($town))<3) {
    echo "Miesto pavadinimas turi tureti bent 3 simbolius";
  }
  elseif (strlen(trim($about))<=5) {
    echo "Turi but maziausiai 10 simboliu";
  }
  else {
    $user = new User();
    $user->update($user_id,$town,$about,$birth,$height,$status,$smoke,$alcohol,$body,$reason);
  }
}
 ?>
