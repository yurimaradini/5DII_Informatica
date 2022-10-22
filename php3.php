<?php

$arr = explode(trim(readline('Dimmi 5 numeri: ')));

$sum;
$ave;

for ($i = 0; $i < count($arr); $i++) {
    $sum += $arr[$i];
}

$ave = $sum / count($arr);

echo $sum;
echo $ave;

?>