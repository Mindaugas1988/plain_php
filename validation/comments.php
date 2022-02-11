<?php
session_start();
require_once("../apps/posts.php");
require_once("../apps/block.php");
if (isset($_POST['text']) && isset($_POST['post_id'])) {
  $block = new Block();
  $user_id = $_SESSION['user'];
  $user_name = $_SESSION['user_name'];
  $text = htmlspecialchars($_POST['text']);
  $post_id = $_POST['post_id'];
  $ip = $_SERVER['REMOTE_ADDR'];
  $id=null;

  if(strlen(trim($text))<=0) {
    echo "Nieko neįrašėt!!!";
  }elseif ($block->is_you_block($id,$user_name,$post_id)===true) {
    echo "Jus esat uzblokuotas šio vartotojo!!!";
  }else {
    include_once("smiles.php");
    $comment = new Comments();
    $comment->add($user_id,$user_name,$text,$post_id,$ip);
  }
}
 ?>
