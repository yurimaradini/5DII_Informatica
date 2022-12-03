<?php 

session_start();

if (!isset($_SESSION['tesoro1'])) {
    $num1 = rand(1, 10);
    do
    {
        $num2 = rand(1, 10);
    } while ($num2 == $num1);

    $_SESSION['tesoro1'] = $num1;
    $_SESSION['tesoro2'] = $num2;
    
    $_SESSION['errori'] = 0;
    $_SESSION['trovati'] = 0;
}
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Trova il Tesoro</title>
    </head>

    <body>
        <form action="TrovaIlTesoro.php" method="POST">
            <input type="submit" value="1" name="button">
            <input type="submit" value="2" name="button">
            <input type="submit" value="3" name="button">
            <input type="submit" value="4" name="button">
            <input type="submit" value="5" name="button">
            <input type="submit" value="6" name="button">
            <input type="submit" value="7" name="button">
            <input type="submit" value="8" name="button">
            <input type="submit" value="9" name="button">
            <input type="submit" value="10" name="button">
        </form>
        
    </body>

</html>

<?php
    if (isset($_POST['button']) && $_POST['button'] != $_SESSION['tesoro2'] && $_POST['button'] != $_SESSION['tesoro1']) {
        
        $_SESSION['errori']++;
        echo "errori:" . $_SESSION['errori'];

        if($_SESSION['errori'] >= 3) {
            echo "<script type='text/javascript'>alert('Hai esaurito i tentativi! I tesori cambieranno posizione.');</script>";
            unset($_POST['button']);
            unset($_POST['tesoro1']);
            session_destroy();
            header('Refresh:0');
        }
    }
    else if (isset($_POST['button'])){
        echo $_POST['button'] . " trovato!";
        if($_SESSION['trovati'] != $_POST['button'] && $_SESSION['trovati'] != 0) {
            echo "<script type='text/javascript'>alert('Hai vinto! Gioca ancora!');</script>";
            unset($_POST['button']);
            unset($_POST['tesoro1']);
            session_destroy();
            header('Refresh:0');
        }
        else {
            $_SESSION['trovati'] = $_POST['button'];
        }

    }


?>