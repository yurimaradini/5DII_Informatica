<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Rossi Cinema - Home</title>
</head>

<body class="bg-black">
  <nav class="flex justify-between">
    <img src="../Cinema/assets/images.jfif">
    <form action="index.html">
      <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-white border-orange-500 py-2 px-4 m-0 text-sm font-medium text-black hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        HOME
      </button>
    </form>
  </nav>

<?php
$filmId = $_POST['movie'];

require_once 'dbconfig.php';

$sql1 = "SELECT Title, Plot, Thumbnail
        FROM `films`
        WHERE Id = :Id;";

$query1 = $dbh->prepare($sql1);

$query1->bindParam(':Id', $filmId, PDO::PARAM_INT);
$query1->execute();

$movie = $query1->fetch(PDO::FETCH_ASSOC);


$sql2 = "SELECT projections.Id, `Room`, `Day`, `Time`
        FROM `projections`
        JOIN films ON films.Id = projections.Film_Id 
        WHERE Film_Id = :filmId ;";

$query2 = $dbh->prepare($sql2);

$query2->bindParam(':filmId', $filmId, PDO::PARAM_INT);
// $query->bindParam(':pw', $password, PDO::PARAM_STR);

$query2->execute();

$projections = $query2->fetchAll(PDO::FETCH_ASSOC);

?>

  <!-- Section: Design Block -->
  <section class="mb-32 text-gray-800 text-justify">
        <div class="block rounded-lg bg-black px-10 ">
        <div class="flex flex-wrap items-center justify-evenly">
            <div class="basis-auto flex w-52">
            <img src=<?=$movie['Thumbnail']?> alt="Trendy Pants and Shoes"
                class="w-full rounded-t-lg" />
            </div>
            <div class="basis-auto w-max-content">
            <div class="">
                <h2 class="text-3xl text-white font-bold mb-6"><?=$movie['Title']?></h2>
                <p class="text-white text-md mb-6">
                <?=$movie['Plot']?>
                </p>
                <form action="room.php" method="POST">
                <div class="flex flex-wrap mb-6">
                    <ul class="flex flex-wrap gap-2">

<?php
$i = 0;

foreach ($projections as $proj) {

  echo "<li>
        <input type='radio' id='hosting-small" . $i . "' name='projection' value=" . $proj['Id'] . " class='hidden peer' required>
        <label for='hosting-small" . $i . "' class='inline-flex justify-between items-center p-2 w-min-content text-gray-400 bg-gray-800 rounded-lg border border-gray-200 cursor-pointer peer-checked:border-orange-500 peer-checked:text-orange-500 hover:text-orange-300 hover:border-orange-300 hover:bg-gray-700 '>                           
        <div class='block'>
            <div class='w-min-content text-lg font-semibold'>" . $proj['Day'] . " - " . $proj['Time'] . "
            </div>
            <div class='w-full'>Sala " . $proj['Room'] . "
            </div>
        </div>
        <svg aria-hidden='true' class='ml-3 w-6 h-6' fill='currentColor' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z' clip-rule='evenodd'></path></svg>
        </label>
      </li>";

  $i++;
}
?>
                  </ul>
                </div>
                <button type="submit" class="inline-block px-7 py-3 bg-gray-800 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out">
                  AVANTI
                </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Section: Design Block -->
