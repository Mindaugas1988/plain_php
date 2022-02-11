<?php
session_start();
require_once("../apps/block.php");
if (isset($_SESSION['user']) && isset($_POST['id'])) {
  $id = $_POST['id'];
  $user = $_SESSION['user'];
  $block = new Block();
  $block->block($user,$id);

}
 ?>
