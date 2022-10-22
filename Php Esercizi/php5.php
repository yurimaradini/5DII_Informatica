<?php

$arr1 = [];
$arr2 = [];

$arr_size = 5;

for($i = 0; $i < $arr_size; $i++) {
    array_push($arr1, (int)readline('Inserisci un numero: '));
}

sort($arr1);
print_r($arr1);

for($i = 0; $i < $arr_size; $i++) {
    array_push($arr2, (int)readline('Inserisci un numero: '));
}

sort($arr2);
print_r($arr2);

$mergedArr = array_merge($arr1, $arr2);
sort($mergedArr);
print_r($mergedArr);
?>