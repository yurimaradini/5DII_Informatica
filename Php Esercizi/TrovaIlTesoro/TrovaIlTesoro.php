<?php

$num1 = rand(0, 9);
do
{
    $num2 = rand(0, 9);
} while ($num2 == $num1);

print_r($_POST);
$guess1 = $_POST[0];
$guess2 = $_POST[1];
?>