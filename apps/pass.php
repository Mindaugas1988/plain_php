<?php
class Pass
{

  private $date;

  function __construct($date)
  {
     $this->date = $date;
  }

  public  function count(){
    date_default_timezone_set("Europe/Vilnius");
    $seniau = strtotime($this->date);
    $dabar = time();
    $praejo = $dabar-$seniau;

    $s=60;
    $m=$s*60;
    $h=$m*24;
    $d=$h*30;
    $mo=$d*12;
    $y=$mo*12;

    if ($praejo<$s)  {
      return $praejo." s.";
    }elseif ($praejo<$m) {
      return floor($praejo/$s)." min.";
    }elseif ($praejo<$h) {
      return floor($praejo/$m)." val.";
    }elseif ($praejo<$d) {
      return floor($praejo/$h)." d.";
    }elseif ($praejo<$mo) {
      return floor($praejo/$d)." mėn.";
    }else{
      return floor($praejo/$mo)." metus";
    }
  }
}
 ?>
