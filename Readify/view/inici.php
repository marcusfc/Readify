<?php
/**
 * @author abel i marc
 */
session_start();
//Recuperem la sessió
require '../model/database.php';//Connexió base de dades


//Recuperem la id ed l'usuari de la sessió oberta i fem la consulta per recuperar els atributs de l'usuari
if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, name, email,password,target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);// Associem el valor de 'user_id' com a paràmetre a la consulta
  $records->execute();//Executem la consulta
  $results = $records->fetch(PDO::FETCH_ASSOC);//obtenim els resultats de la consulta

  $user = null;
//Pasem tots els atributs a la variable user
  if (count($results) > 0) {//comprobem si hi han resultats
    $user = $results;//Assigenm els resultats a la variable user
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/style2.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../scripts/buscarlibro.js"></script>
</head>
<body>

<!--Posem el header amb el logo, el usuari del perfil i el botò de sortir-->
<div class="header">
<img src="../images/image.png" alt="">
  <div class="espaisinici">
    <a href="../controller/logout.php" class="buttonLogOut">➲</a>
    <div class="user-anon"> 
    <a href="perfil.php"><img src="../images/usuarioanon.png" alt=""></a>
    </div>
  </div>
</div>

<!--Fem un menú amb els apartats de Readify-->
<div class="row">
  <div class="col-2 col-s-3 menu">
    <ul>
    <li><a href="../controller/mislibros.php" style="text-decoration: none; display: block;">Mis Libros</a></li>
    <li><a href="../model/autores.php" style="text-decoration: none; display: block;">Autores</a></li>
    <li><a href="qr.php" style="text-decoration: none; display: block;">Lector QR</a></li>
    <li><a href="../model/config.php" style="text-decoration: none; display: block;">Configuración</a></li>

    <!--Posem un buscador amb el que es podrà buscar per llibre o per autor-->
    <input type="search" placeholder="Libros, autores..." id="search-input">
    <button type="button" onclick="buscarLibro()">🔍</button>
    </ul>
  </div>

 


<!--Posem els llibres amb els seus corresponents id-->
  <div class="col-9 col-s-9">
    <div class="book">
    <img class="imagen" src="../images/quijote.jpg" data-id="1">
      <p>1.Don Quijote de la Mancha</p>
    </div>
    <div class="book">
    <img class="imagen" src="../images/alicia.jpg" data-id="3">
      <p>2.Alicia a través del Espejo</p>
    </div>
    <div class="book">
      <img class="imagen" src="../images/magodeoz.png" data-id="2">
      <p>3.El Maravilloso Mago de Oz</p>
    </div>
    <div class="book">
      <img class="imagen" src="../images/kafka.png" data-id="4">
      <p>4.La Metamorfosis</p>
    </div>
    <div class="book">
      <img class="nofunciona" src="../images/flashman.jpg" data-id="5">
      <p>5.Flashman</p>
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
  //Utilitzem la funció per agafar la id al clicar la imatge però en aquest cas el llibre no estarà disponible fins una data
  $(document).ready(function() {
    $('.nofunciona').click(function() {
      var id = $(this).data('id');
      alert("Disponible a partir del 01-07-2023")
    });
  });
  
  /**
   * Carrega la finestra dels detalls del llibre passant com a paràmetre la id del llibre
   */
  function cargarVentanaDetalle(id) {
  window.location.href = 'ventanadetalle.php?id=' + id;
}
  </script>
  <!--Posem el footer recollint el nom de l'usuari actiu-->
</body>
<br>
<br>
<br>
<div class="footer">
  <p>Has iniciado sesión como <?= $user['name']; ?> </p>
</div>
</html>
