<?php
session_start();
if (isset($_SESSION['user']) && isset($_POST['member'])) {
  require_once("../apps/member_filter.php");
 $member = htmlspecialchars($_POST['member']);

 $filter = new Filter();
 $filter->search_member($member);

}
 ?>
