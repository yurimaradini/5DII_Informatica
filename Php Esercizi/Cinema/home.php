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

<body>
  <nav class="flex justify-between">
    <img src="../Cinema/assets/images.jfif">
    <form action="index.html">
      <button type="submit" class="group relative flex w-full justify-center rounded-md border border-transparent bg-white border-orange-500 py-2 px-4 m-0 text-sm font-medium text-black hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        HOME
      </button>
    </form>
  </nav>

<?php 

require_once 'dbconfig.php';

$sql = "SELECT `Id`, `Title`, `Plot`, `Thumbnail` 
          FROM `films`";

$query = $dbh->prepare($sql); //irrilevante perchè la query non contiene parametri

// $query->bindParam(':em', $email, PDO::PARAM_STR);
// $query->bindParam(':pw', $password, PDO::PARAM_STR);

$query->execute();

$res = $query->fetch(PDO::FETCH_ASSOC);

?>
  
  <div class="flex-col flex-nowrap justify-center h-fit min-h-fit px-5">
    <!-- MOVIE -->
    <div class="w-full min-w-52 flex h-fit min-h-fit max-h-52 p-2 border-2 rounded border-gray-400 my-6"> <!-- max-w-sm -->
      <div class="h-30 w-32 mb-1 flex-none bg-contain bg-no-repeat text-center overflow-hidden" style="background-image: url('assets/avatar.jpg')" title="Avatar - Le vie dell'acqua"> <!--h-48 rounded-t-->
      </div>
      <div class="bg-black rounded-b-none rounded-r flex flex-col justify-between leading-3 ml-2"> <!--border-l rounded-b-->
        <div class="mb-2">
          <div class="text-white font-bold text-xl mb-2">Titolo Film</div>
          <p class="text-gray-400 text-base">Trama Film Trama Film Trama Film Trama Film Trama Film Trama Film Trama Film Trama Film Trama Film Trama Film Trama Film</p>
        </div>
        <div class="flex items-center">
          <form action="film.php" method="POST">
            <button type="submit" value="film_Id" class="group relative w-50 justify-left rounded-md border-2 border-transparent bg-black border-orange-500 py-2 px-4 text-sm font-medium text-white hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
              ACQUISTA ORA
            </button>
          </form>
        </div>
      </div>
    </div>

</body>