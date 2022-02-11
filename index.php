<?php
session_start();
if (isset($_SESSION['user'])) {
header("Location:pasiskelbk.php");
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
   <div class="w3-third" id="login-form">
     <form>
       <input type="text" placeholder="Vartotojo vardas"/>
       <div class="reg-error" id="log-error-nick"></div>
       <input type="password" placeholder="Slaptazodis"/>
       <div class="reg-error" id="log-error-password"></div>
       <label><a href="#" id="go_remember">Pamiršai?</a></label></br>
       <div class="reg-error" id="log-error"></div>
       <input type="button" value="Prisijungti"/>
     </form>
   </div>
   </div>
   <div class="w3-col s12" id="reg-string">
    <h2>Registracija</h2>
   </div>
   <div class="w3-third">
   &nbsp
   </div>
   <div class="w3-third" id="reg-form">
     <form>
       <input type="text" name="name" placeholder="Vartotojo vardas"/>
       <div class="reg-error" id="reg-error-name"></div>
       <input type="password" name="password" placeholder="Slaptazodis"/>
       <div class="reg-error" id="reg-error-password"></div>
       <input type="text" name="email" placeholder="Elektroninis pastas" title=""/>
       <div class="reg-error" id="reg-error-email"></div>
       <select name="diena">
         <option value="Diena">Diena</option>
         <script>
         for (var i = 1; i <= 31; i++) {
          document.write("<option value='"+i+"'>" +i+ "</option>");
         }
         </script>
       </select>
       <select name="menuo">
         <option value="Mėnuo">Mėnuo</option>
         <script>
         for (var i = 1; i <= 12; i++) {
          document.write("<option value='"+i+"'>" +i+ "</option>");
         }
         </script>
       </select>
       <select name="metai">
         <option value="Metai">Metai</option>
         <script>
         var date = new Date();
         var years = date.getFullYear();
         var begin =years-18;
         for (var i = begin; i > 1900; i--) {
          document.write("<option value='"+i+"'>" +i+ "</option>");
         }
         </script>
       </select></br>
       <div class="reg-error" id="reg-error-date"></div>
       <label>Lytis:</label></br>
       <input type="radio" name="sex" value="Vyras" id="man_radio" checked="true"/>
       <label for="man_radio">Vyras</label>
       <input type="radio" name="sex" value="Moteris" id="woman_radio"/>
       <label for="woman_radio">Moteris</label>
       </br>
       <div class="reg-error" id="reg-error-form"></div>
       <input type="button" id="o" value="Registruotis"/>
     </form>
   </div>
   <div class="w3-third">
   &nbsp
   </div>
 </div>
 <div id="email_forget" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom">
    <header class="w3-container w3-teal">
      <span onclick="document.getElementById('email_forget').style.display='none'" class="w3-closebtn">&times;</span>
      Prisiminti slaptažodį
    </header>
    <div class="w3-container">
      <form>
        <label>Jūsų elektroninis paštas</label></br>
        <input type="email" name="email" id="email"/></br>
        <input type="button" value="Siųsti"/>
      </form>
    </div>
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

<div class="w3-container w3-teal footer">
  <a href="about.php">Apie</a>
  <a href="rules.php">Taisyklės</a>
  <a href="contact.php">Kontaktai ir pagalba</a>
</div>
 <script type="text/javascript" src="jquery/script.js"></script>
</body>
</html>
