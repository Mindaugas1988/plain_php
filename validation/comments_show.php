<?php
session_start();
require_once("../apps/posts.php");
if (isset($_SESSION['user']) && isset($_POST['id'])) {
  $user_id = $_SESSION['user'];
  $id = $_POST['id'];
  $comment = new Comments();
  $comment->show($id,"../photos/");

}
 ?>
