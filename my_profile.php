<?php
session_start();
require_once("apps/photos.php");
if (isset($_SESSION['user'])) {
  require_once("apps/user.php");
  $user_id = $_SESSION['user'];
  $dir = "photos/".$user_id."/";
  $photos = scandir($dir);
  $user = new User();
  $user->user($user_id);

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
    <li><img src="images/photo.png" alt="email"/><a href="photos.php">Nuotraukos</a><span class="w3-tag"><?php echo count($photos)-2;?></span></li>
    <li class="active"><img src="images/profile.png" alt="email"/><a href="my_profile.php">Anketa</a></li>
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
        <h6>Profilis</h6>
      </div>

      <div class="photo-slider">
      <!--<img class="mySlides" src="photos/tenebra_new-29 (1).jpg">-->
      <?php
      $photo = new Photos();
      $photo->photoProfile($user_id);
       ?>


     </div>
     <ul class="info">
       <h6>Vartotojo informacija</h6>
       <li>Vartotojo vardas:<span><?php echo $user->name; ?></span></li>
       <li>Lytis:<span><?php echo $user->sex; ?></span></li>
       <li>Miestas:<span><?php echo $user->town; ?></span></li>
       <li>Amžius:<span><?php echo $user->age; ?></span></li>
       <li>Statusas:<span><?php echo $user->relationship; ?></span></li>
       <li>Rūkymas:<span><?php echo $user->smoke; ?></span></li>
       <li>Alkoholis:<span><?php echo $user->alcohol; ?></span></li>
       <li>Ūgis:<span><?php echo $user->height; ?></span></li>
       <li>Sudėjimas:<span><?php echo $user->body; ?></span></li>
       <li>Ieškau:<span><?php echo $user->point; ?></span></li>
       <!--<li>Online</li>-->
        <input type="button" value="Redaguoti profilį"/ id="profile_btn"></br>
        <input type="button" value="Trinti profilį" id="profile_dlt"/>
     </ul>

    <div id="about">
      <h6>Apie mane:</h6>
    <?php echo $user->about; ?>
    </div>
    <div id="friends-list">
      <h6>Draugai(0)</h6>

    </div>

    </div>
 </div>

 <div id="modal_upgrate" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom">
    <header class="w3-container w3-teal">
      <span onclick="document.getElementById('modal_upgrate').style.display='none'" class="w3-closebtn">&times;</span>
      Redaguoti profilį
    </header>
    <div class="w3-container navbar">
      <ul class="w3-navbar">
         <li><a href="#" onclick="openForm(event,'info')" style="font-weight:bold;">Redaguoti informaciją</a></li>
         <li><a href="#" onclick="openForm(event,'info_login')">Redaguoti prisijungimo duomenis</a></li>
     </ul>

     <div id="info" class="w3-container form">
      <form>
        <label>Gyvenamoji vieta</label></br>
        <input type="text" name="place" id="place" value="<?php echo $user->town?>"/></br>
        <label>Gimimo data</label></br>
        <select name="diena">
          <option value="<?php echo $user->day?>"><?php echo $user->day; ?></option>
          <script>
          for (var i = 1; i <= 31; i++) {
           document.write("<option value='"+i+"'>" +i+ "</option>");
          }
          </script>
        </select>
        <select name="menuo">
          <option value="<?php echo $user->month?>"><?php echo $user->month?></option>
          <script>
          for (var i = 1; i <= 12; i++) {
           document.write("<option value='"+i+"'>" +i+ "</option>");
          }
          </script>
        </select>
        <select name="metai">
          <option value="<?php echo $user->year?>"><?php echo $user->year?></option>
          <script>
          var date = new Date();
          var years = date.getFullYear();
          var begin =years-18;
          for (var i = begin; i > 1900; i--) {
           document.write("<option value='"+i+"'>" +i+ "</option>");
          }
          </script>
        </select></br>
        <label>Statusas</label></br>
        <select name="statusas">
          <option value="Vienišas">Vienišas</option>
          <option value="Užimtas">Užimtas</option>
          <option value="Neapsisprendęs">Neapsisprendęs</option>
        </select></br>
        <label>Rūkymas</label></br>
        <select name="smoke">
          <option value="Dažnai">Dažnai</option>
          <option value="Kartais">Kartais</option>
          <option value="Nerūkau">Nerūkau</option>
        </select></br>
        <label>Alkoholis</label></br>
        <select name="alcohol">
          <option value="Dažnai">Dažnai</option>
          <option value="Kartais">Kartais</option>
          <option value="Negeriu">Negeriu</option>
        </select></br>
        <label>Ūgis</label></br>
        <select name="tall">
          <script>
          for (var i = 100; i <= 250; i++) {
           document.write("<option value='"+i+"'>" +i+ "</option>");
          }
          </script>
        </select>cm</br>
        <label>Sudėjimas</label></br>
        <select name="body">
          <option value="Lieknas">Lieknas</option>
          <option value="Vidutinis">Vidutinis</option>
          <option value="Stambus">Stambus</option>
        </select></br>
        <label>Ieškau</label></br>
        <select name="reason">
          <option value="Moters">Moters</option>
          <option value="Vyro">Vyro</option>
          <option value="Poros">Poros</option>
        </select></br>
        <label>Apie mane</label></br>
        <textarea name="about" placeholder="Apie mane"><?php echo $user->about?></textarea></br>
        <input type="button" value="Pakeisti"/>
      </form>
    </div>

     <div id="info_login" class="w3-container form" style="display:none">
      <form>
        <label>Vartotojo vardas</label></br>
        <input type="text" name="name" id="name" value="<?php echo $user->name?>"/></br>
        <label>Senas slaptažodis</label></br>
        <input type="password" name="password" id="password"/></br>
        <label>Naujas slaptažodis</label></br>
        <input type="password" name="new-password" id="new-password"/></br>
        <label>Elektroninis paštas</label></br>
        <input type="email" name="email" id="email" title="" value="<?php echo $user->email?>"/></br>
        <input type="button" value="Pakeisti"/>
      </form>
     </div>

    </div>
  </div>
 </div>

 <div id="modal_delete" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom">
    <header class="w3-container w3-teal">
      <span onclick="document.getElementById('modal_delete').style.display='none'" class="w3-closebtn">&times;</span>
      Ištrinti profilį
    </header>
    <div class="w3-container">
      <form>
        <label>Jūsų slaptažodis</label></br>
        <input type="password" name="password_dlt" id="password_dlt"/></br>
        <input type="button" value="Ištrinti"/>
      </form>
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
