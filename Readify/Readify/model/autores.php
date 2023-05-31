<?php
/**
 * @author abel i marc
 */
session_start();
// Recuperem la sessió de l'usuari actiu
require 'database.php';
 // Agafem les dades de l'arxiu database.php per seguir amb la connexió de la base de dades

// Agafem la id de l'usuari actiu i fem una consulta per agafar els atributs
if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, name, email, password, target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);// Associem el valor de 'user_id' com a paràmetre a la consulta
  $records->execute();//Executem la consulta
  $results = $records->fetch(PDO::FETCH_ASSOC);//obtenim els resultats de la consulta

  $user = null;

  // Passem els resultats a la variable user
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
<!-- Posem el header amb el logo, el usuari del perfil i el botò de sortir -->
<div class="header">
  <a href="../view/inici.php"><img src="../images/image.png"></a>
  <div class="espaisinici">
    <a href="../controller/logout.php" class="buttonLogOut">➲</a>
    <div class="user-anon2">
      <a href="../view/perfil.php"><img src="../images/usuarioanon.png" alt=""></a>
    </div>
  </div>
</div>
<!--titol autors-->
<h1>Autores</h1>
<!--Introduim tots els autors-->
<div class="col-9 col-s-9">
  <div class="book">
    <img class="imagen" src="../images/mc.jpg" data-id="1">
    <p>Miguel de Cervantes</p>
  </div>
  <div class="book">
    <img class="imagen" src="../images/lc.jpg" data-id="2">
    <p>Lewis Carroll</p>
  </div>
  <div class="book">
    <img class="imagen" src="../images/lfb.jpg" data-id="3">
    <p>L. Frank Baum</p>
  </div>
  <div class="book">
    <img class="imagen" src="../images/ac.jpg" data-id="4">
    <p>Agatha Christie</p>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.imagen').click(function() {
      var id = $(this).data('id');// S'obté' el valor del atribut de dades 'id' del element en el que s'ha fet clic i s'asigna a la variable 'id'
      cargarVentanaDetalle(id);// Crida a la funció 'cargarVentanaDetalle' passant el valor 'id' com argument
    });
  });

  // Carrega la finestra dels detalls del llibre passant com a paràmetre la id del llibre
  function cargarVentanaDetalle(id) {
    window.location.href = '../controller/detalleautor.php?id=' + id;
  }
</script>
</div>
</body>
</html>
