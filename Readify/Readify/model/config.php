<?php
/**
 * @author abel i marc
 */
session_start();
//Recuperem la sessió que está oberta

require '../model/database.php'; //Seguim fent la connexió a la base de dades agafant la informació de l'arxiu database.php

//Si la sessió segueix oberta recuperem la id de l'usuari
if (isset($_SESSION['user_id'])) {
  //Fem una consulta per recuperar les dades de la id de la sessió oberta
  $records = $conn->prepare('SELECT id, name, email,password,target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);// Associem el valor de 'user_id' com a paràmetre a la consulta
  $records->execute();//executem consulta
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
<link rel="stylesheet" href="../assets/style2.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <!--Introduim el header amb el logo i botons perfil i sortir-->
  <div class="header">
    <a href="../view/inici.php"><img src="../images/image.png"></a>
    <div class="espaisinici">
      <a href="../controller/logout.php" class="buttonLogOut">➲</a>
      <div class="user-anon2">
        <a href="../view/perfil.php"><img src="../images/usuarioanon.png" alt=""></a>
      </div>
    </div>
  </div>

  <!--Posem el text amb una checkbox per mostrar les diferents opcions de la configuració-->
  <div class="config">
    <p>Control parental</p>
    <input type="checkbox" id="controlParental">
  </div>
  <div class="config">
    <p>Notificaciones</p>
    <input type="checkbox" id="notificaciones">
  </div>
  <div class="config">
    <p>Tamaño de letra:</p>
    <select id="fontSizeSelector">
      <option value="12">12</option>
      <option value="16">16</option>
      <option value="20">20</option>
    </select>
  </div>
  <div class="config">
    <p>Brillo pantalla:</p>
    <input type="range" id="brilloSlider" min="0" max="100" value="50" step="1">
  </div>
  <!--afegim un botó per aplicar els canvis fets en les opcions anteriors-->
  <br>
  <br>
  <button class="button">Aceptar cambios</button>

  <!-- Afegim mail de suport de Readify -->
  <p>Soporte: <a href="mailto:soporte@example.com">soporte@readify.com</a></p>
  <br>
  <br>

</body>
</html>
