<?php
session_start();
//Recuperem la sessió de l'usuari actiu
require 'database.php'; //Utilitzem l'arxiu database.php per mantenir la connexió a la base de dades


//Recuperem els atributs de l'usuari aconseguint la id i fent una consulta a la base de dades
if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, name, email,password,target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;
//Es passa els resultats a la variable user
  if (count($results) > 0) {
    $user = $results;
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Perfil</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
  </head>
  <body>
    <header>
      <!--Posem el logo de readify-->
      <div class="logo-container">
      <a href="inici.php"><img src="./image.png" width="260px"/></a>
      </div>
    </header>
</head>
<body>
<!--Crrem el requadre on es mostrarà la informació del perfil-->
  <div class="profile">
  <div class="junt">
    <h1>Perfil</h1>
    <!--Posem la imatge del perfil de l'usuari al costat de el text perfil-->
    <div class="user-anon"> 
    <img src="./usuarioanon.png" alt=""></a>
  </div>
</div>
<!--Dins del requadre introduim el nom, el email i el numero de la targeta recuperant la informació de la base de dades al principi de l'arxiu-->
    <div class="profile-info">
      <label>Nombre:</label>
      <p><?= $user['name']; ?></p>
      <label>Email:</label>
      <p><?= $user['email']; ?></p>
      <label>Número Targeta:</label>
      <p><?= $user['target']; ?></p>
    </div>
    <br>
    <!--Posem un botò per canviar la contrasenya que anirá a l'arxiu canviacontrasenya.php-->
    <a href="canviacontrasenya.php" class="button">Cambiar contraseña</a>
    <?php
    //Quan es fa l'acció torna i mostra el missatge que està en update_password.php per saber si s'ha actualitzat bé o no
    if (isset($_GET['message'])) {
      $message = $_GET['message'];
      echo '<p>' . $message . '</p>';
    }
  ?>
  </div>
</body>
</html>