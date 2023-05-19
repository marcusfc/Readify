<?php
session_start();
//Recuperem la sessió que está oberta

require 'database.php'; //Seguim fent la connexió a la base de dades agafant la informació de l'arxiu database.php

//Si la sessió segueix oberta recuperem la id de l'usuari
if (isset($_SESSION['user_id'])) {
  //Fem una consulta per recuperar les dades de la id de la sessió oberta
  $records = $conn->prepare('SELECT id, name, email,password,target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;
//Posem els resultats dins de la variable usuari
  if (count($results) > 0) {
    $user = $results;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/style2.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <!--Introduim el header amb el logo-->
<div class="header">
<a href="index.php"><img src="./image.png"></a>
</div>
<!--Posem el text amb una checkbox per mostrar el control parental-->
<div class="config">
  <p>Control parental</p>
  <input type="checkbox" id="controlParental">
</div>
<!--Posem el footer recuperant el nom de l'usuari per mostrar-ho -->
<div class="footer">
  <p>Has iniciado session como <?= $user['name']; ?> </p>
</div>
</body>
</html>
