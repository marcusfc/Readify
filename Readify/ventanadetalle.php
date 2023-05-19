<?php
session_start();
//Recuperem la sessió de l'usuari actiu
require 'database.php'; //RAgafem les dades de l'arxiu databse.php per seguir amb la connexió de la base de dades

//Agafem la id de l'usuari actiu i fem una consulta per agafar els atrbuts
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
// Obté el ID del registre
$id = $_GET['id'];


// Utilitza aquesta configuració per la base de dades
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "readify";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

//Fa la consulta per obtenir el llibre que s'ha de mostrar
$sql = "SELECT * FROM libros WHERE id = $id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/style2.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!--Mostra el header amb el logo, la imatge del perfil de l'uusari i el botò de sortir-->
<div class="header">
<a href="inici.php"><img src="./image.png"></a>
  <div class="espaisinici">
    <a href="logout.php" class="buttonLogOut">➲</a>
    <div class="user-anon2"> 
        <a href="perfil.php"><img src="./usuarioanon.png" alt=""></a>
    </div>
  </div>
</div>

    <!--Si hi ha resultats agafa les columnes del llibre i les passa a la variable row-->
    <?php
    if ($result->num_rows > 0) {
    // Mostrar los datos del registro
    $row = $result->fetch_assoc();
    //Mostrem el titol, la imatge,el resum, la data de publicació i l'autor del llibre amb la variable row i la id de la columna
    echo "<h1>" .$row["titulo"] . "</h1>";
    echo "<img class='imagen' src=" .$row["imagen"] . ">";?>
    <br>
    <br>
    <?php
    echo "<div class='resumen'>" . $row["resumen"] . "</div>";
    echo "<p>Fecha de Publicación: " . $row["fechapubli"] . "</p>";
    echo "<p>Género: " . $row["genero"] . "</p>";
    echo "<p>ISBN: " . $row["ISBN"] . "</p>";
    echo "<p>Número de páginas: " . $row["numpag"] . "</p>";
    echo "<p>Autor: " . $row["Autor"] . "</p>";
    
    //Fem un botò que enllaça a l'arxiu leerlibro.php
    ?>
   <a href="leerlibro.php?id=<?= $id ?>" class="button">Leer libro</a>
    <a href="" class="button">📚</a>
    <?php
    //Si no troba registre mostra un missatge de que no s'ha trobat cap registre
} else {
    echo "No se encontró ningún registro con ese ID";
}
?>
  </div>
  <!--Mostrem el footer amb el nom de l'usuari actiu-->
  <div class="footer">
        <p>Has iniciado sesión como <?= $user['name']; ?> </p>
    </div>
</body>
</html>