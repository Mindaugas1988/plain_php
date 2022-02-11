<?php
session_start();
require_once("../apps/photos.php");
if (isset($_POST['first']) && isset($_POST['last']) && isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];
  $first = $_POST['first'];
  $last = $_POST['last'];
  if ($first == null || $first == "" || $last == null || $last == "") {
    echo "Tuscia";
  }else {
    $photo = new Photos();
    $photo->changePhoto($user_id,$first,$last);
  }
}
 ?>
