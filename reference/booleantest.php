<?php
function check($int) {
    if ($int == 3) {
       return true;
    } else {
       return false;
    }
 }
 
 if (check(3) == true) echo "Returned true!";
 echo '<br />';
 if (check(4) == false) echo "Returned false!";
?>
