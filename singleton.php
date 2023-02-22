<?php

 function differetiateNumbers($array) {
    foreach ($array as  $value) {
        if($value%2 == 1) {
            echo "Odd->".$value."\n";
        }
        elseif($value%2 == 0) {
            echo "Even->".$value."\n";
        }
    }
 }

 $array = [2, 5, 6, 3, 0];
differetiateNumbers($array);
?>