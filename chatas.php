<?php
session_start();

$page = $_SERVER['PHP_SELF'];
$sec = "30";
header("Refresh: $sec; url=$page");

if (isset($_SESSION['user'])) {
require_once("apps/chat.php");
require_once("apps/user.php");
require_once("apps/pagination.php");
$user_id = $_SESSION['user'];
$dir = "photos/".$user_id."/";
$photos = scandir($dir);
$user = new User();
$chat = new Chat();

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
  <link rel="stylesheet" type="text/css" media="screen" href="styles/css.css"/>
  <link rel="stylesheet" type="text/css" media="screen" href="styles/jquery-ui.css"/>
  <script type="text/javascript" src="jquery/jquery.js"></script>
  <script type="text/javascript" src="jquery/jquery-ui.js"></script>
</head>
<body>
<div id="page">

  <!--<div id="notific_msg" class="w3-panel w3-hide-large">
 </div>

  <div id="notific_visitor" class="w3-panel w3-hide-large">
  </div>

  <div id="notific_friends" class="w3-panel w3-hide-large">
     <span onclick="this.parentElement.style.display='none'" class="w3-closebtn">&times;</span>
   <a href="messages.php">Nauji kvietimai draugauti</a>
 </div>-->

  <nav class="w3-sidenav w3-collapse w3-card-1 w3-animate-left" style="width:200px;" id="mySidenav">
    <a href="javascript:void(0)" onclick="w3_close()"
    class="w3-closenav w3-large w3-hide-large">Close &times;</a>
    <div class="string">
    <h6>Tiurlys.lt</h6>
    </div>
    <ul>
    <li><img src="images/email.png" alt="email"/><a href="messages.php">Žinutės</a><span class="w3-tag"></span></li>
    <li><img src="images/visitors.png" alt="email"/><a href="visitors.php">Svečiai</a><span class="w3-tag visit"></span></li>
    <li><img src="images/photo.png" alt="email"/><a href="photos.php">Nuotraukos</a><span class="w3-tag"><?php echo count($photos)-2;?></span></li>
    <li><img src="images/profile.png" alt="email"/><a href="my_profile.php">Anketa</a></li>
    <li><img src="images/member.png" alt="email"/><a href="member.php">Nariai</a><span class="w3-tag"><?php echo $user->all_count(); ?></span></li>
    <li><img src="images/chat.png" alt="email"/><a href="pasiskelbk.php">Pasiskelbk</a><span class="w3-tag"></span></li>
    <li class="active"><img src="images/chat.png" alt="email"/><a href="chatas.php">Chatas</a><span class="w3-tag"></span></li>
    <li><img src="images/friends.png" alt="email"/><a href="friends.php">Draugai</a><span class="w3-tag"></span></li>
    <li><img src="images/block.png" alt="email"/><a href="block_list.php">Užblokuotieji</a><span class="w3-tag"></span></li>
    </ul>
    <div class="clear"></div>
    <div class="string"><h6>Nauji nariai</h6></div>
    <ul id="new_member-list">
    <!--<li><a href="#"><img src="photos/avatar_81d2fdbd224e_64.png" alt="email"/></a></li>-->
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
        <textarea placeholder="Rašyti skelbimą..." name ="new_chat"></textarea>
        <div class="error" id="chat_error"></div>
        <input type="button" id="new_chat_btn" value="Skelbti"/>
        <img id="smiles_btn" src="images/smile.png" alt="(angry)"/ title="Sypseneles"/>
      </form>
    </div>

    <div class="w3-col s12" id="content">
      <div id="content_header">
        <a href="validation/logout.php"><img src="images/logout.png" title="Atsijungti"/></a>
        <h6>Pokalbiai</h6>
      </div>
    <div id ="inbox" class="box">
      <?php
      $chat->show($page);
      ?>
    </div>
     <?php
     $row = $chat->all_count();
     $location = $_SERVER['PHP_SELF'];
     $pagination = new Pagination($row,10,$page,$location);
     ?>
    </div>
 </div>

 <div id="smiles" class="w3-modal">
  <div class="w3-modal-content">
    <span onclick="document.getElementById('smiles').style.display='none'" class="w3-closebtn">&times;</span>
    <div class="w3-container">
      <img src="emoticons/smileys-afraid-885309.gif" alt="(afraid)"/>
      <img src="emoticons/smileys-angry-662871.gif" alt="(angry)"/>
      <img src="emoticons/hi2.gif" alt="(hi2)"/>
      <img src="emoticons/hi.gif" alt="(hi)"/>
      <img src="emoticons/horse.gif" alt="(horse)"/>
      <img src="emoticons/laugh.gif" alt="(laugh)"/>
      <img src="emoticons/quitar.gif" alt="(quitar)"/>
      <img src="emoticons/dj.gif" alt="(dj)"/>
      <img src="emoticons/shit.gif" alt="(shit)"/>
      <img src="emoticons/s0249.gif" alt="(cool)"/>
      <img src="emoticons/s0321.gif" alt="(kiss)"/>
      <img src="emoticons/s0311.gif" alt="(love)"/>
      <img src="emoticons/s0952.gif" alt="(swim)"/>
      <img src="emoticons/smile.gif" alt=":)"/>
      <img src="emoticons/sad.gif" alt=":("/>
      <img src="emoticons/d.gif" alt=":D"/>
      <img src="emoticons/blum.gif" alt="(blum)"/>
      <img src="emoticons/secret.gif" alt="(secret)"/>
      <img src="emoticons/shout.gif" alt="(shout)"/>
      <img src="emoticons/wink3.gif" alt="(wink3)"/>
      <img src="emoticons/air_kiss.gif" alt="(air_kiss)"/>
    </div>
  </div>
 </div>

 <div id="msg_error" class="w3-modal">
  <div class="w3-modal-content">
    <!--<span onclick="document.getElementById('msg_error').style.display='none'" class="w3-closebtn">&times;</span>-->
    <div class="w3-container">
      <p> Nieko neįrasėt!!!</p>
      <input type="button" onclick="document.getElementById('msg_error').style.display='none'" value="Gerai"/>
    </div>
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
</html>
