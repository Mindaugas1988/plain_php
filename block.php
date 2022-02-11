<?php
session_start();
if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];
  $id = $_GET['name'];
  require_once("apps/block.php");
  $block = new Block();
  require_once("apps/user.php");
  $user = new User();
  $getID = $user->getID($id);

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
   <style>
   #post-reader_header,#content,#content_header{margin:0;}
   #content_header{margin-top:-10px; position: relative;}
   #content_header img{
     margin: 6px 0 6px 10px;
     height:32px;
     width:32px;
     right:10px; position:absolute;}
     h5{text-align: center; font-weight: bold; padding: 10px;}
     h5 a{color:blue;}
   </style>
 </head>
 <body>
 <div id="page">

   <div class="w3-row w3-main">
     <div class="w3-col s12" id="post-reader_header">
     </div>
     <div class="w3-col s12" id="content">
       <div id="content_header">
         <a href="validation/logout.php"><img src="images/logout.png" title="Atsijungti"/></a>
         <h6>Jūs užblokuotas</h6>
       </div>

       <?php
          if ($block->is_block($user_id,$id)===true) {
            echo '<h5>Jūs šį vartotoją taip pat užblokavę <a href="#" id="unblock_link">Atblokuoti</a></h5>';
          }else {
            echo '<h5>Dėmesio,Jūs užblokuotas, galite taip pat <a href="#" id="block_link">Užblokuoti</a></h5>';
          }
        ?>


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
  <script>
  $(document).ready(function(){
  block_member();
  unblock_member();
  });

  function block_member(){
    $("#block_link").click(function(){
      var url= window.location.href;
      var x = url.indexOf("=")+1;
      var y = url.length;
      var id = url.slice(x,y);
      $.post(
        "validation/blocked.php",
        {id:id},
        function(data){
          if (data==1) {
            location.reload();
          }else {
            $("#msg_error").css("display","block");
            $("#msg_error .w3-modal-content .w3-container p").html(data);
          }
        }
      )
    });
  }


  function unblock_member(){
    $("#unblock_link").click(function(){
      var url= window.location.href;
      var x = url.indexOf("=")+1;
      var y = url.length;
      var id = url.slice(x,y);
      $.post(
        "validation/unblocked.php",
        {id:id},
        function(data){
          if (data==1) {
            location.reload();
          }else {
            $("#msg_error").css("display","block");
            $("#msg_error .w3-modal-content .w3-container p").html(data);
          }
        }
      )
    });
  }
  </script>
 </body>
 </html>
