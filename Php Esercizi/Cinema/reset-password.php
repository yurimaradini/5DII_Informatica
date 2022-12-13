<?php

require_once 'dbconfig.php';

$email = trim($_POST['email']);
$new_password = trim($_POST['password']);

$sql = "SELECT `Id` 
          FROM `users`
          WHERE Email=:em;";

$query = $dbh->prepare($sql);

$query->bindParam(':em', $email, PDO::PARAM_STR);

$query->execute();

$userId = $query->fetch(PDO::FETCH_ASSOC);

if($userId != false) {
    $sql2 = "UPDATE `users`
    SET `Password` = (:pw)
    WHERE `Id` = (:id);";

    $query2 = $dbh->prepare($sql2);

    $query2->bindParam(':id', $userId, PDO::PARAM_INT);
    $query2->bindParam(':pw', $new_password, PDO::PARAM_STR);

    $query2->execute();
}

header('Content-Type: application/text; charset-utf-8');
header('Location: login.html');
exit(0);


?>