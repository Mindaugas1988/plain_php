<?php
session_start();
if (isset($_SESSION['user'])) {
  require_once("apps/user.php");
  require_once("apps/member_filter.php");
  require_once("apps/pagination.php");
  $user_id = $_SESSION['user'];
  $dir = "photos/".$user_id."/";
  $photos = scandir($dir);
  $user = new User();
  $filter = new Filter();

  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }else {
    $page = 1;
  }

}else {
header("Location:index.php");
}
 ?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Tiurlys.lt</title>
  <meta charset="utf-8"/>
  <link rel="shortcut icon" href="images/chat-icon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" media="screen" href="styles/reset.css"/>
  <link rel="stylesheet" type="text/css" media="screen" href="styles/w3.css"/>
  <link rel="stylesheet" type="text/css" media="screen" href="styles/jquery-ui.css"/>
  <link rel="stylesheet" type="text/css" media="screen" href="styles/css.css"/>
  <script type="text/javascript" src="jquery/jquery.js"></script>
  <script type="text/javascript" src="jquery/jquery-ui.js"></script>
</head>
<body>
<div id="page">

  <nav class="w3-sidenav w3-collapse w3-card-1 w3-animate-left" style="width:200px;" id="mySidenav">
    <a href="javascript:void(0)" onclick="w3_close()"
    class="w3-closenav w3-large w3-hide-large">Close &times;</a>
    <div class="string"><h6>Tiurlys.lt</h6></div>
    <ul>
    <li><img src="images/email.png" alt="email"/><a href="messages.php">Žinutės</a><span class="w3-tag"></span></li>
    <li><img src="images/visitors.png" alt="email"/><a href="visitors.php">Svečiai</a><span class="w3-tag visit"></span></li>
    <li><img src="images/photo.png" alt="email"/><a href="photos.php">Nuotraukos</a><span class="w3-tag"><?php echo count($photos)-2;?></span></li>
    <li><img src="images/profile.png" alt="email"/><a href="my_profile.php">Anketa</a></li>
    <li class="active"><img src="images/member.png" alt="email"/><a href="member.php">Nariai</a><span class="w3-tag"><?php echo $user->all_count(); ?></span></li>
    <li><img src="images/chat.png" alt="email"/><a href="pasiskelbk.php">Pasiskelbk</a><span class="w3-tag"></span></li>
    <li><img src="images/chat.png" alt="email"/><a href="chatas.php">Chatas</a><span class="w3-tag"></span></li>
    <li><img src="images/friends.png" alt="email"/><a href="friends.php">Draugai</a><span class="w3-tag"></span></li>
    <li><img src="images/block.png" alt="email"/><a href="block_list.php">Užblokuotieji</a><span class="w3-tag"></span></li>
    </ul>
    <div class="clear"></div>
    <div class="string"><h6>Nauji nariai</h6></div>
    <ul id="new_member-list">
      <?php
      $user->new_member();
      ?>
    </ul>
    <div class="string"></div>
  </nav>

  <div class="w3-row w3-main">
  <span class="w3-opennav w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</span>
    <div class="w3-col s12" id="post-reader_header">
      <form class="w3-col s12">
        <input type="text" placeholder="Vartotojo vardas..." name="new_srch"/></br>
        <div class="error" id="search_error"></div>
        <input type="button" id="new_srch_btn" value="Ieškoti"/>
      </form>
    </div>
    <div class="w3-col s12" id="content">
      <div id="content_header">
        <a href="validation/logout.php"><img src="images/logout.png" title="Atsijungti"/></a>
        <h6>Nariai</h6>
      </div>
      <form id="filter">
        <h6>Amžiaus filtras:</h6>
        <div id="slider-age">
          <input type="text" id="amount1" name="amount1" readonly/>
          <input type="text" id="amount2" name="amount2" readonly/>
        </div>
       <div id="check">
        <input type="checkbox" name="man" value="man" checked id="man">
        <label for="man">Vyrai</label>
        <input type="checkbox" name="woman" value="woman" checked id="woman">
        <label for="woman">Moterys</label>
        <input type="checkbox" name="online" value="online" checked id="online">
        <label for="online">Online</label>
        <input type="text" name="location" placeholder="Visi miestai" id="location">
        <input type="button" value="Filtruoti"/>
      </div>
      </form>
    <div id="photos-member">
      <?php
      $filter->get_filter($user_id);
      $filter->all_member($page);
       ?>
    </div>
    <?php
      $row = $filter->page_count();
      $location = $_SERVER['PHP_SELF'];
      $pagination = new Pagination($row,10,$page,$location);
     ?>
    </div>
 </div>
 </div>
 <div class="w3-container w3-teal footer">
   <a href="about.php">Apie</a>
   <a href="rules.php">Taisyklės</a>
   <a href="contact.php">Kontaktai ir pagalba</a>
</div>
 <script type="text/javascript" src="jquery/script.js"></script>
</body>
<div id="max"><?php echo $filter->max; ?></div>
<div id="min"><?php echo $filter->min; ?></div>
</html>
