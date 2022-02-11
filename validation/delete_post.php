<?php
session_start();
require_once("../apps/posts.php");
if (isset($_POST['post_id']) && isset($_SESSION['user'])) {
  $post_id = $_POST['post_id'];

  $post = new Posts();
  $post->delete($post_id);
}
 ?>
