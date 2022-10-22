<?php

$arr1 = [];

for($i = 0; $i < 10; $i++) {
    $x = rand(1, 90);

    if (!in_array($x, $arr1)) {
        array_push($arr1, $x);
    }
}

print_r($arr1);
?>