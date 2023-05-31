<?php
/**
 * @author abel i marc
 */
//Agafa les dades de l'arxiu database.php
require '../model/database.php';

//Declarem la variable message en blanc
$message = '';

//Aqui comprovem que no estigui buit tant la contrasenya com el email
if (!empty($_POST['email']) && !empty($_POST['password'])) {

  $sql = "SELECT * FROM users WHERE email = :email";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':email', $_POST['email']);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

//Comprova que s'han omplert tots els camps
  // Comprobar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si hay campos vacíos
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password']) || empty($_POST['target'])) {
    $message = 'Error, todos los campos son obligatorios';
  } 
 else {
    //Si ja existeix l'usuari doncs ens avisarà amb un missatge que el correu ja ha estat registrat
    if ($user) {
      $message = 'Error, el correo electrónico ya está registrado';
     //Sino, el que farà es insertar les dades introduides de l'usuari a la bbdd
    } else {
      $sql = "INSERT INTO users (name, email, password, target) VALUES (:name, :email, :password, :target)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':name', $_POST['name']);
      $stmt->bindParam(':email', $_POST['email']);
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $stmt->bindParam(':password', $password);
      $stmt->bindParam(':target', $_POST['target']);
  
      //Un cop registrat l'usuari, llavors es creará una variable que guardará un missatge de que s'ha creat correctament
      if ($stmt->execute()) {
        $message = 'Enhorabuena, usuario creado correctamente';
      } else {
        $message = 'Error, usuario no creado';
      }
    }
  }
}
  

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!--titol-->
    <title>Registro</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
    <header>
      <!--Posem el header amb el logo de readify-->
      <div class="logo-container">
      <a href="../index.php"><img src="../images/image.png" width="260px" alt=""></a>
      </div>
    </header>
    <!--Mostra el missatge per saber si l'usari s'ha creat correctament o no-->
    <div class="login-box1">
    <?php if(!empty($message)): ?>
        <p><?= $message ?></p>
      <?php endif; ?>
      <h1>Registrarse</h1>
        <!--Aqui es fa un formulari amb els camps que s'han d'omplir i fa un post per publicar els resultats a la base de dades-->
      <form action="signup.php" method="POST">
        <input name="name" type="text" placeholder="Introduce nombre">
        <input name="email" type="text" placeholder="Introduce E-mail">
        <input name="password" type="password" placeholder="Introduce contraseña">
        <input name="confirm_password" type="password" placeholder="Confirma contraseña">
        <input name="target" type="text" placeholder="Número Tarjeta">
        <input type="submit" value="Registrarse">
      </form>
    </div>
  </body>
</html>