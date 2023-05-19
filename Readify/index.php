<?php
  session_start();
//Recuperem la sessió que está oberta
  require 'database.php'; //Seguim fent la connexió a la base de dades agafant la informació de l'arxiu database.php

  //Si la sessió segueix oberta recuperem la id de l'usuari
  if (isset($_SESSION['user_id'])) {
     //Fem una consulta per recuperar les dades de la id de la sessió oberta
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;
//Posem els resultats dins de la variable usuari
    if (count($results) > 0) {
      $user = $results;
    }
    header('Location: ./inici.php');
  }
?>


<!DOCTYPE html>
<link rel="stylesheet" href="assets/style.css">
<html>
<head>
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
  <!--Afegim el logo de Readify-->
  <header> 
  <div class="logo-container">
  <img src="./image.png" width="260px" alt="">
  </div>
  </header>
  <!--Afegim el titol de la pàgina web-->
  <title>Readify</title>
  <!--Si tens l'usuari introduit llavors et dirigeix a l'incici de Readify-->
  <?php if(!empty($user)): 
    header('Location: ./inici.php');?>
    <!--Si no, et mostra la pàgina index on et mostrarà uns missatges i podràs escollir iniciar sessió o registrar-te-->
  <?php else: ?>
    <h1 class="titol">Readify</h1>
    <br>
    <br>
    <br>
    <h2>Libros, Autores y más…</h2>
    <h3>Lee donde quieras. Cancela cuando quieras.</h3>
    <h4>¿Quieres leer algo ya?</h4>
    <h4>Crea una suscripción a Readify o reactívala.</h4>
    <br>
    <!--botons d'iniciar sessió i registre-->
    <a href="login.php" class="button">Iniciar Sesión</a>  
    <a href="signup.php" class="button">Registrarse</a>
  <?php endif; ?>
</body>
