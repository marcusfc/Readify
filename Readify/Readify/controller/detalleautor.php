<?php
/**
 * @author abel i marc
 */
session_start();
//Recuperem la sessió de l'usuari actiu
require '../model/database.php'; //Agafem les dades de l'arxiu databse.php per seguir amb la connexió de la base de dades


//Agafem la id de l'usuari actiu i fem una consulta per agafar els atributs
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

//conectem
$conn = new mysqli($servername, $username, $password, $dbname);

//si tenim un error de conexió ens mosrarà un missatge
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


//Fa la consulta per obtenir el llibre que s'ha de mostrar
$sql = "SELECT * FROM autores WHERE id = $id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/style2.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>


<!--Mostra el header amb el logo, la imatge del perfil de l'uusari i el botò de sortir-->
<div class="header">
<a href="../view/inici.php"><img src="../images/image.png"></a>
  <div class="espaisinici">
    <a href="logout.php" class="buttonLogOut">➲</a>
    <div class="user-anon2">
        <a href="../view/perfil.php"><img src="../images/usuarioanon.png" alt=""></a>
    </div>
  </div>
</div>


    <!--Si hi ha resultats agafa les columnes de l'autor i les passa a la variable row-->
    <?php
    if ($result->num_rows > 0) {
    // Mostrar les dades del registre
    $row = $result->fetch_assoc();
    //Mostrem les dades del autor
    echo "<h1>" .$row["name"] . "</h1>";
    echo "<img class='imagen' src=" .$row["imagen"] . ">";?>
    <br>
    <br>
    <?php
     echo "<div class='details'>";
    echo "<p>" . $row["biography"];
    echo "</div>";
    echo "<p><strong>Fecha Nacimiento:</strong> " . $row["birth_date"] . "</p>";
    echo "<p><strong>Fecha Fallecimiento:</strong> " . $row["date_of_death"] . "</p>";
    echo "<p><strong>Nacionalidad:</strong> " . $row["nationality"] . "</p>";
    echo "<p><strong>Género:</strong> " . $row["literary_genre"] . "</p>";
    echo "<p><strong>Obras Destacadas:</strong> " . $row["outstanding_works"] . "</p>";
    ?>
    <?php
    //Si no troba registre mostra un missatge de que no s'ha trobat cap registre
} else {
    echo "No se encontró ningún registro con ese ID";
}
?>
  </div>
<br>
<br>
</body>
</html>