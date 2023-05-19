<?php
session_start();
//Recuperem la sessió
require 'database.php';//Connexió base de dades

//Recuperem la id ed l'usuari de la sessió oberta i fem la consulta per recuperar els atributs de l'usuari
if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, name, email,password,target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;
//Pasem tots els atributs a la variable user
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

<!--Posem el header amb el logo, el usuari del perfil i el botò de sortir-->
<div class="header">
<img src="./image.png" alt="">
  <div class="espaisinici">
    <a href="logout.php" class="buttonLogOut">➲</a>
    <div class="user-anon"> 
    <a href="perfil.php"><img src="./usuarioanon.png" alt=""></a>
    </div>
  </div>
</div>

<!--Fem un menú amb els apartats de Readify-->
<div class="row">
  <div class="col-3 col-s-3 menu">
    <ul>
    <li><a href="bgh" style="text-decoration: none;">Mis Libros</a></li>
    <li><a href="" style="text-decoration: none;">Autores</a></li>
    <li><a href="qr.php" style="text-decoration: none;">Lector Código de Barras</a></li>
    <li><a href="config.php" style="text-decoration: none;">Configuración</a></li>
    <!--Posem un buscador amb el que es podrà buscar per llibre o per autor-->
    <input type="search" placeholder="Libros, autores...">
    <button type="submit">🔍</button>
    </ul>
  </div>

<!--Posem els llibres amb id-->
  <div class="col-9 col-s-9">
    <div class="book">
    <img class="imagen" src="./quijote.jpg" data-id="1">
      <p>1.Don Quijote de la Mancha</p>
    </div>
    <div class="book">
    <img class="imagen" src="./alicia.jpg" data-id="3">
      <p>2.Alicia a través del Espejo</p>
    </div>
    <div class="book">
      <img class="imagen" src="./magodeoz.png" data-id="2">
      <p>3.El Maravilloso Mago de Oz</p>
    </div>
  </div>
</div>
<!--Utilitzem la funció per agafar la id al clicar la imatge-->
<script>
$(document).ready(function() {
    $('.imagen').click(function() {
      var id = $(this).data('id');
      cargarVentanaDetalle(id);
    });
  });
  
  //Carrega la finestra dels detalls del llibre passant com a paràmetre la id del llibre
  function cargarVentanaDetalle(id) {
  window.location.href = 'ventanadetalle.php?id=' + id;
}
  </script>
  <!--Posem el footer recollint el nom de l'usuari actiu-->
<div class="footer">
  <p>Has iniciado sesión como <?= $user['name']; ?> </p>
</div>
</body>
</html>
