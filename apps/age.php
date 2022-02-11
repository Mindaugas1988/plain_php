<?php
/**
 *
 */
class Age
{

public function years($date){

date_default_timezone_set("Europe/Vilnius");
$date3 = date("Y-m-d");

$date1=date_create($date);
$date2=date_create($date3);
$diff=date_diff($date1,$date2);
return $diff->format("%y m.");
}

}

 ?>
