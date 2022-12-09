<?php
try {
    $hostname = "localhost";
    $dbname = "cinema";
    $user = "admin";
    $pass = "admin";
    $dbh = new PDO ("mysql:host=$hostname;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}
?>