<?php
session_start();
if (isset($_SESSION['user']) || isset($_GET['id'])==false || isset($_GET['name'])==false ) {
//header("Location:chatas.php");
header("Location:http://www.tiurlys.lt/chatas.php");
}else{
require_once("apps/recover.php");
$id = $_GET['id'];
$name = $_GET['name'];
$location = $_SERVER['PHP_SELF'];
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
  <div class="w3-row">
   <div class="w3-col s12" id="header">
   <img src="images/cover.jpg"/>
   </div>
   <div class="w3-col s12" id="reg-string">
    <h2>Naujo slaptažodžio sukūrimas</h2>
   </div>
   <div class="w3-third">
   &nbsp
   </div>
   <div class="w3-third" id="recover-form">
     <form action="<?php echo "$location?id=$id&name=$name";?>" method="post">
       <input type="password" placeholder="Naujas slaptažodis" name="password"/>
       <input type="password" placeholder="Pakartoti slaptažodį" name="repeat_password"/>
       <input type="submit" value="Pakeisti"/>
     </form>

     <?php

     if (isset($_POST['password']) && isset($_POST['repeat_password'])) {
       $password = htmlspecialchars($_POST['password']);
       $repeat_password = htmlspecialchars($_POST['repeat_password']);

       if (strlen(trim($password))<=3) {
          echo "<p style ='color:red; font-size:12px; margin-left:5%;'>Neįrašėt slaptažodžio arba jis trumpesnis nei 4 simboliai</p>";
        }elseif ($password!=$repeat_password) {
          echo "<p style ='color:red; font-size:12px;margin-left:5%;'>Nesutampa slaptažodžių laukeliai</p>";
        }else{
         $recover = new Recover($password,$name,$id);
        }


     }
      ?>
   </div>
   <div class="w3-third">
   &nbsp
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
