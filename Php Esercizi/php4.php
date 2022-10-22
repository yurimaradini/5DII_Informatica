<?php

$arr = [];

array_push($arr, readline('Inserisci un numero: '));
array_push($arr, readline('Inserisci un numero: '));

while ($arr[count($arr) - 1] != $arr[count($arr) - 2]) {
array_push($arr, readline('Inserisci un numero: '));
}

print_r($arr);

?>