<?php
  /**
   * @author abel i marc
   */
  session_start();
//Recuperem la sessió que está oberta
  require 'model/database.php'; //Seguim fent la connexió a la base de dades agafant la informació de l'arxiu database.php

  //Si la sessió segueix oberta recuperem la id de l'usuari
  if (isset($_SESSION['user_id'])) {
     //Fem una consulta per recuperar les dades de la id de la sessió oberta
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']); // Associem el valor de 'user_id' com a paràmetre a la consulta
    $records->execute();//Executem la consulta
    $results = $records->fetch(PDO::FETCH_ASSOC);//obtenim els resultats de la consulta
    
    $user = null;
//Posem els resultats dins de la variable usuari
    if (count($results) > 0) {//comprobem si hi han resultats
      $user = $results;//Assigenm els resultats a la variable user
    }
    header('Location: view/inici.php');//Enviem a l'usari a la pàgina d'inici de Readify
  }
?>


<!DOCTYPE html>
<link rel="stylesheet" href="./assets/style.css">
<html>
<head>
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
  
  <!--Afegim el logo de Readify-->
  <header> 
  <div class="logo-container">
  <img src="images/image.png" width="260px" alt="">
  </div>
  </header>
  <!--Afegim el titol de la pàgina web-->
  <title>Readify</title>
  <!--Si tens l'usuari introduit llavors et dirigeix a l'incici de Readify-->
  <?php if(!empty($user)): 
    header('Location: view/inici.php');?>
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
    <a href="controller/login.php" class="button">Iniciar Sesión</a>  
    <a href="controller/signup.php" class="button">Registrarse</a>
  <?php endif; ?>
</body>
</html>
