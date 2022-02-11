<?php
require_once("../apps/photos.php");
session_start();
if (isset($_SESSION['user']) && isset($_FILES['upload_file'])) {
$user_id = $_SESSION['user'];
$files = $_FILES['upload_file'];
date_default_timezone_set("Europe/Vilnius");
$date = date("Y-m-d H:i:s");

$imagedata = getimagesize($files['tmp_name']);

if ($imagedata[0]<600) {
  echo "Per mažas nuotraukos dydis, plotis turi būti didesnis nei 600px";
}
else {
  $photos = new Photos();
  $photos->upload($user_id,$files,$date);
}

}
 ?>
