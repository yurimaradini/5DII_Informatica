<?php

require_once 'dbconfig.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = "INSERT IGNORE INTO `users` (`Id`, `Name`, `Email`, `Password`)
        VALUES (NULL, :n, :em, :pw);";

$query = $dbh->prepare($sql);

$query->bindParam(':n', $name, PDO::PARAM_STR);
$query->bindParam(':em', $email, PDO::PARAM_STR);
$query->bindParam(':pw', $password, PDO::PARAM_STR);

$query->execute();

if($query->rowCount() == 0) {
    echo "<script>
            alert('I dati inseriti non sono validi o sono già stati utilizzati.');
          </script>";
    exit(1);
}
    
    header('Content-Type: application/text; charset-utf-8');
    header('Location: index.html');
    exit(0);


?>