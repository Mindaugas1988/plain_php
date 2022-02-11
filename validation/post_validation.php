<?php
session_start();
require_once("../apps/posts.php");
if (isset($_POST['text'])) {
  $user_id = $_SESSION['user'];
  $user_name = $_SESSION['user_name'];
  $text = htmlspecialchars($_POST['text']);

  if(strlen(trim($text))<=0) {
    echo "Nieko neįrašėt!!!";
  }else {
    include_once("smiles.php");
    $post = new Posts();
    $post->add($user_id,$user_name,$text);
  }
}
 ?>
