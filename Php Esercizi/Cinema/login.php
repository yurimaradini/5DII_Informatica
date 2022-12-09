<?php

require_once 'dbconfig.php';

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = "SELECT `Id`, `Name`, `Email`, `Password` 
          FROM `users`
          WHERE Email=:em and Password=:pw;";

$query = $dbh->prepare($sql);

$query->bindParam(':em', $email, PDO::PARAM_STR);
$query->bindParam(':pw', $password, PDO::PARAM_STR);

$query->execute();

$res = $query->fetch(PDO::FETCH_ASSOC);

if($res != false) {
    header('Content-Type: application/text; charset-utf-8');
    exit(1);
}

session_start();

$_SESSION['Id'] = $res['Id'];
$_SESSION['Name'] = $res['Name'];
$_SESSION['Email'] = $res['Email'];
$_SESSION['Password'] = $res['Password'];

header('Content-Type: application/text; charset-utf-8');
header('Location: home.php/');
exit(0);


?>