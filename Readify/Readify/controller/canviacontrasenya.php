<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!--titol-->
    <title>Perfil</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
  </head>
  <body>
    <!--Aqui posem la imatge de logo que clicant anirás a la pàgina principal-->
    <header>
      <div class="logo-container">
      <a href="../view/inici.php"><img src="../images/image.png" width="260px" alt=""></a>
      </div>
    </header>
</head>
<body>
  <!--Aqui tenim dues caixes on introduirem la contrasenya actual i la nova-->
  <div class="profile">
<div class="change-password">
      <h2>Cambiar Contraseña</h2>
      <br>
      <!--Fem un formulari on s'actualitzará la contrasenya a través d'una altre classe que es diu update_password.php-->
      <form action="../model/update_password.php" method="POST">
        <label>Contraseña Actual:</label>
        <input type="password" name="current_password" required>
        <label>Nueva Contraseña:</label>
        <input type="password" name="new_password" required>
        <br>
       <!--introduim el botó per aplicar canvis-->
       <button class="button">Cambiar contraseña</a>  
      </form>
    </div>