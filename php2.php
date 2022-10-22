<?php 

function TimeInSec($h, $m, $s) {
    return $h * 3600 + $m * 60 + $s;
}

$arr = explode('.', trim(readline("inserisci un tempo: ")));

echo TimeInSec($arr[0], $arr[1], $arr[2]);

$time1 = explode('.', trim(readline("inserisci un tempo: ")));
$time2 = explode('.', trim(readline("inserisci un altro tempo: ")));

if (TimeInSec($time1[0], $time1[1], $time1[2]) > TimeInSec($time2[0], $time2[1], $time2[2])) {
    echo 'il primo tempo è maggiore del secondo';
}
else {
    echo 'il secondo tempo è maggiore del primo';
}
?>