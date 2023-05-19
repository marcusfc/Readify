<!--Inicia la sessió de l'usuari-->

<?php
  session_start();

  //Agafa la id de l'usuari de la pàgina del index-->
  if (isset($_SESSION['user_id'])) {
    header('Location: ./index.php');
  }
  //Agafa les dades de l'arxiu database.php
  require 'database.php';

  //Aqui comprovem que no estigui buit tant la contrasenya com el email
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
  
    //Aqui fem una consulta per mirar si el que ha escrit l'usuari coincideix amb el registre de la base de dades
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $email);
    $records->execute();
  
    $user = $records->fetch(PDO::FETCH_ASSOC);
  
    //Si l'usuari i la contrasenya són correctes, s'agafa la id de l'usuari i accedeix a l'index amb l'usuari.
    //Com tindrás usuari doncs et redirigirá a la pàgina principal de readify amb la informació de l'usuari.
    if ($user && password_verify($_POST['password'], $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      header("Location: ./index.php");
    } else {
      //Si no es correcte mostrará aquest missatge
      $message = 'Usuario o contraseña incorrecto';
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
  </head>
  <body>
  <header> 
    <!--Coloquem la imatge de readify-->
  <div class="logo-container">
  <a href="index.php"><img src="./image.png" width="260px"/></a> 
  </div>
  </header>
  <br>
  <!--Aquesta es la caixa del login on sortirà per escriure el email i la contrasenya-->
    <div class="login-box">
      <?php if(!empty($message)): ?>
        <p> <?= $message ?></p>
      <?php endif; ?>

      <h1>Iniciar Sesión</h1>
      
      <form action="login.php" method="POST">
        <input name="email" type="text" placeholder="E-Mail">
        <input name="password" type="password" placeholder="Contraseña">
        <br>
        <input type="submit" value="Entrar">
      </form>
    </div>
  </body>
</html>
