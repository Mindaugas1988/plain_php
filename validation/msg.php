<?php
session_start();
require_once("../apps/messages.php");
require_once("../apps/block.php");
if (isset($_POST['text'])&&isset($_POST['id'])) {
  # code...
  $block = new Block();
  date_default_timezone_set("Europe/Vilnius");
  $user_id = $_SESSION['user'];
  $user_name = $_SESSION['user_name'];
  $text = htmlspecialchars($_POST['text']);
  $id = $_POST['id'];
  $date = date("Y-m-d H:i:s");

  if(strlen(trim($text))<=0) {
    echo "Nieko neįrašėt!!!";
  }elseif ($block->is_you_block($id,$user_name)===true) {
    echo "Jus esat uzblokuotas šio vartotojo!!!";
  }else {
    include_once("smiles.php");
    $msg = new Messages();
    $msg->send($id,$user_id,$user_name,$text,$date);
  }
}
 ?>
