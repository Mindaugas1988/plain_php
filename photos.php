<?php
session_start();

if (isset($_SESSION['user'])) {
require_once("apps/user.php");
require_once("apps/photos.php");
$user_id = $_SESSION['user'];
$user = new User();
$dir = "photos/".$user_id."/";
$photos = scandir($dir);
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

  <nav class="w3-sidenav w3-collapse w3-card-1 w3-animate-left" style="width:200px;" id="mySidenav">
    <a href="javascript:void(0)" onclick="w3_close()"
    class="w3-closenav w3-large w3-hide-large">Close &times;</a>
    <div class="string"><h6>Tiurlys.lt</h6></div>
    <ul>
    <li><img src="images/email.png" alt="email"/><a href="messages.php">Žinutės</a><span class="w3-tag"></span></li>
    <li><img src="images/visitors.png" alt="email"/><a href="visitors.php">Svečiai</a><span class="w3-tag visit"></span></li>
    <li class="active"><img src="images/photo.png" alt="email"/><a href="photos.php">Nuotraukos</a><span class="w3-tag"><?php echo count($photos)-2;?></span></li>
    <li><img src="images/profile.png" alt="email"/><a href="my_profile.php">Anketa</a></li>
    <li><img src="images/member.png" alt="email"/><a href="member.php">Nariai</a><span class="w3-tag"><?php echo $user->all_count(); ?></span></li>
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

    </div>
    <div class="w3-col s12" id="content">
      <div id="content_header">
        <a href="validation/logout.php"><img src="images/logout.png" title="Atsijungti"/></a>
        <h6>Nuotraukos</h6>
      </div>
    <input type="button" value="Ikelti daugiau" id="upload_button"></input>
    <div id="photos">
      <!--<div class="w3-third">
        <img src="photos/tenebra_new-29 (1).jpg" alt="email"/>
        <div class="opacity-photo">
          <p><img src="images\photo-album-icon-png.png"/><a href="#">Padaryti pagrindine</a></p>
          <p><img src="images\remove-icon.png"/><a href="#">Trinti</a></p>
        </div>
      </div>-->
      <?php
       $album = new Photos();
       $album->photoAlbum($user_id);
       ?>
    </div>

    </div>
 </div>
 <script type="text/javascript" src="jquery/script.js"></script>
 <div id="modal" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom">
    <header class="w3-container w3-teal">
      <span onclick="document.getElementById('modal').style.display='none'" class="w3-closebtn">&times;</span>
      Ikelti nuotraukas
    </header>
    <div class="w3-container">
      <form enctype="multipart/form-data" id="upload_form" action="validation/upload_file.php" method="post">
        <input type="file" accept="image/*" name="upload_file" id="upload_file"></br>
        <input type="button" id="upload_file_btn" value="Ikelti"/>
      </form>
      <div class="error" id="post_upload_photo"></div>
    </div>
  </div>
</div>
</div>
<div class="w3-container w3-teal footer">
  <a href="about.php">Apie</a>
  <a href="rules.php">Taisyklės</a>
  <a href="contact.php">Kontaktai ir pagalba</a>
</div>
</body>
</html>