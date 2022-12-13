<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Rossi Cinema - Selezione posti</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black">

    <form action="rent-seats.php" method="POST">
    <div class=" justify-center  flex flex-wrap flex-col ">
        
<?php
    $projId = $_POST['projection'];

    require_once 'dbconfig.php';

    $sql = "SELECT `Occupied`
            FROM `projections`
            WHERE Id = :Id;";

    $query = $dbh->prepare($sql);

    $query->bindParam(':Id', $projId, PDO::PARAM_INT);
    $query->execute();

    $occupied_seats = $query->fetch(PDO::FETCH_ASSOC);

    $occupied_array = explode(',', $occupied_seats['Occupied']);

    $room_seats = 50;
    $row_seats = 8;
    
    for ($i = 0; $i < $room_seats; $i++) {
        echo "<div class='justify-center flex flex-nowrap flex-row'>";
        for ($j = 0; $j < $row_seats && $i < $room_seats; $j++) {
            $class_attribute = "";
            if(in_array($i, $occupied_array)) {
                $class_attribute = "pointer-events-none opacity-50 ";
            }
            echo "<div id=".$i." onclick='select(this)' class='".$class_attribute."w-12 h-12 rounded-t-lg bg-neutral-400 mx-3 my-1 hover:bg-opacity-75 hover:scale-110 duration-75'></div>";
        $i++;
        }
    echo "</div>";
    }

?>
        
        <input type="hidden" name="projectionId" value="<?=$projId?>">
        <input type="hidden" id="selected_buttons" name="selected_buttons" value="" >
        <button type="submit" class="group relative flex w-52 justify-center rounded-md border border-transparent bg-white border-orange-500 py-2 mt-10 mx-auto mb-10 text-sm font-medium text-black hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            BUY NOW
        </button>
        </div>

        <div class="mx-auto mt-10 bg-black text-white text-center">Totale: <b id="prezzo">0.00€</b></div>
    </form>
        <script>
            let prezzo = parseFloat((document.getElementById('prezzo').innerText - "€").innerText) || 0.00;
            function select(button) {
                document.getElementById('prezzo').innerText = document.getElementById('prezzo').innerText - "€";
                console.log(document.getElementById("selected_buttons").value);
                if(button.classList.contains("bg-green-500")) {
                    button.classList.remove("bg-green-500");
                    document.getElementById("selected_buttons").value = document.getElementById("selected_buttons").value.replace("," + button.id, "");
                    
                    prezzo = prezzo - 7.99;
                    document.getElementById('prezzo').innerText = Math.floor(prezzo * 100)/100 + "€";
                    return;
                }
                button.classList.add("bg-green-500");
                document.getElementById("selected_buttons").value += "," + button.id;
                prezzo = prezzo + 7.99;
                document.getElementById('prezzo').innerText = Math.ceil(prezzo * 100)/100  + "€";
            }
        </script>
</body>
</html>