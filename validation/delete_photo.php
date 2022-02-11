<?php
session_start();
require_once("../apps/photos.php");
if (isset($_POST['photo']) && isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];
  $photo = $_POST['photo'];
  if ($photo == null || $photo == "") {
    echo "Klaida ištrinant nuotrauką priš";
  }else {
    $photo_class = new Photos();
    $photo_class->deletePhoto($user_id,$photo);
  }
}
 ?>
