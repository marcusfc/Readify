<?php
session_start();
//Recuperem la sessió de l'usuari
require 'database.php'; //Agafem la infromació de la base de dades

//Aconseguim la id de l'usuari actiu i fem una consulta per saber els seus atributs
if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, name, email,password,target FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
  
    $user = null;
  
    //Passem els resultats a la variable user
    if (count($results) > 0) {
      $user = $results;
    }
}
//Agafa la id del llibre
$id = $_GET['id'];

// Variable amb el link que s'utilitza per agafar el text dels llibres
if($id == 1){
  $url = 'https://www.vienablues.com/quijote.txt';
}
else if($id == 2){
  $url = 'https://www.vienablues.com/mago.txt';
}

else if($id == 3){
  $url = 'https://www.vienablues.com/alicia.txt';
}


// Obtenir el contingut complet de l'arxiu
$fileContent = file($url);

// Número de línies a mostrar per pàgina
$linesPerPage = 5;

// Obté la pàgina actual
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calcula l'índex de l'inici i final per obtenir les línies de la pàgina actual
$startIndex = ($page - 1) * $linesPerPage;
$endIndex = $startIndex + $linesPerPage;

// Obté les línies de la pàgina actual
$lines = array_slice($fileContent, $startIndex, $linesPerPage);

// Calcula el número total de pàgines
$totalPages = ceil(count($fileContent) / $linesPerPage);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Leer Libro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/style2.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <!--Posem el header amb el logo,el botò de sortir i el perfil de l'usuari-->
  <div class="header">
    <a href="inici.php"><img src="./image.png"></a>
    <div class="espaisinici">
      <a href="logout.php" class="buttonLogOut">➲</a>
      <div class="user-anon2"> 
        <a href="perfil.php"><img src="./usuarioanon.png" alt=""></a>
      </div>
    </div>
  </div>
  <div class="container">
    <!--Un requadre que contindrà el text del llibre-->
    <div class="box">
      <?php
      // Mostra les línies de la pàgina actual
      foreach ($lines as $line) {
        echo nl2br(htmlspecialchars($line));
      }
      ?>
    </div>
  </div>
  <div class="llegirllibres">
    <!--Botons per avançar i retrocedir de pàgina-->
    <?php if ($page > 1) { ?>
      <a href="?id=<?php echo $id; ?>&page=<?php echo ($page - 1); ?>" class="buttonllegir">Página Anterior</a>
    <?php } ?>
    <?php if ($page < $totalPages) { ?>
      <a href="?id=<?php echo $id; ?>&page=<?php echo ($page + 1); ?>" class="buttonllegir">Siguiente Página</a>
    <?php } ?>
  </div>
  <!--Fotter per mostrar el nom de l'usuari actiu-->
  <div class="footer">
    <p>Has iniciado sesión como <?= $user['name']; ?></p>
  </div>
</body>
</html>