<?php
echo "hello";
    $occupied_seats = strval($_POST['selected_buttons']);
    $projId = $_POST['projectionId'];
    echo $projId;
echo $occupied_seats;
    require_once 'dbconfig.php';

    $sql = "UPDATE `projections`
            SET `Occupied` = Occupied + (:occupied_seats)
            WHERE `Id` = (:Id);";

    $query = $dbh->prepare($sql);

    $query->bindParam(':occupied_seats', $occupied_seats, PDO::PARAM_STR);
    $query->bindParam(':Id', $projId, PDO::PARAM_INT);

    $query->execute();

//header("location:home.php");
?>