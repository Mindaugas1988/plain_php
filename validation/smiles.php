<?php
$text = str_replace("(dj)","<img src='emoticons/dj.gif'/>",$text);
$text = str_replace("(hi)","<img src='emoticons/hi.gif'/>",$text);
$text = str_replace("(hi2)","<img src='emoticons/hi2.gif'/>",$text);
$text = str_replace("(horse)","<img src='emoticons/horse.gif'/>",$text);
$text = str_replace("(laugh)","<img src='emoticons/laugh.gif'/>",$text);
$text = str_replace("(quitar)","<img src='emoticons/quitar.gif'/>",$text);
$text = str_replace("(cool)","<img src='emoticons/s0249.gif'/>",$text);
$text = str_replace("(love)","<img src='emoticons/s0311.gif'/>",$text);
$text = str_replace("(kiss)","<img src='emoticons/s0321.gif'/>",$text);
$text = str_replace("(swim)","<img src='emoticons/s0952.gif'/>",$text);
$text = str_replace("(shit)","<img src='emoticons/shit.gif'/>",$text);
$text = str_replace("(afraid)","<img src='emoticons/smileys-afraid-885309.gif'/>",$text);
$text = str_replace("(angry)","<img src='emoticons/smileys-angry-662871.gif'/>",$text);
$text = str_replace(":)","<img src='emoticons/smile.gif'/>",$text);
$text = str_replace(":(","<img src='emoticons/sad.gif'/>",$text);
$text = str_replace(":D","<img src='emoticons/d.gif'/>",$text);
$text = str_replace("(blum)","<img src='emoticons/blum.gif'/>",$text);
$text = str_replace("(secret)","<img src='emoticons/secret.gif'/>",$text);
$text = str_replace("(shout)","<img src='emoticons/shout.gif'/>",$text);
$text = str_replace("(wink3)","<img src='emoticons/wink3.gif'/>",$text);
$text = str_replace("(air_kiss)","<img src='emoticons/air_kiss.gif'/>",$text);

$patterns1 = "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~";
$patterns2 = "~[[:alpha:]]+://[www.youtube.com/watch?v=][^<>[:space:]]+[[:alnum:]/]~";

$replacements1 = "<a target ='blank' href=\"\\0\">\\0</a>";
$replacements2 = '<iframe width="100%" height="auto" src="https://www.youtube.com/embed/XGSy3_Czz8k"></iframe>';
$text = preg_replace($patterns1,$replacements1,$text);

 ?>
