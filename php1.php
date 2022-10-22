<?php 

$arr = explode(',', trim(readline("inserisci 3 lati: ")));
$arr = sort($arr);

if ($arr[0]**2 + $arr[1]**2 == $arr[2]**2) {
    echo "Il triangolo è rettangolo";
}
else {
    echo "Il triangolo non è rettangolo";
}

?>