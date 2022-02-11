<?php

class Pagination
{

  function __construct($row_count,$limit,$page,$location)
  {
    $page_count = ceil($row_count/$limit);
    $f = $page+1;
    $b = $page-1;

    if ($page_count==1 || $page_count==0) {
      echo "";
    }else {
      if ($page==1) {
        echo "<ul class='w3-pagination w3-border w3-round ovall'>
                  <li><a href='$location?page=$f'>Toliau &#10095;</a></li>
             </ul>
             ";
        # code...
      }elseif ($page==$page_count) {
        echo "<ul class='w3-pagination w3-border w3-round ovall'>
                  <li><a href='$location?page=$b'>&#10094; Atgal</a></li>
             </ul>
             ";
      }else {
        echo "<ul class='w3-pagination w3-border w3-round ovall'>
                  <li><a href='$location?page=$b'>&#10094; Atgal</a></li>
                  <li><a href='$location?page=$f'>Toliau &#10095;</a></li>
             </ul>
             ";
      }
    }


  }
}
 ?>
