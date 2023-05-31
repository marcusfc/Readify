<?php
/**
 * @author abel i marc
 */
session_start();
require '../model/database.php';//Agafa les dades de l'arxiu database.php

//Si la sessió segueix oberta recuperem la id de l'usuari
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  //Fem una consulta per recuperar les dades de la id de la sessió oberta
  $records = $conn->prepare('SELECT id, name, email,password,target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);// Associem el valor de 'user_id' com a paràmetre a la consulta
  $records->execute();//executem consulta
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;

  //Passem els resultats a la variable user
  if (count($results) > 0) {
    $user = $results;
  }
  // Verificar si s'ha enviat el parametre "add" en la URL
  if (isset($_GET['add']) && $_GET['add'] == 'true') {
    // Obtenir el ID del llibre a afegir desde la URL
    $book_id = $_GET['id'];

    // Verificar si el libre ja està en la llista del usuari
    $conn = new PDO('mysql:host=localhost;dbname=readify', 'root', '');
    $stmt = $conn->prepare('SELECT * FROM mis_libros WHERE id_usuario = :id_usuario AND id_libro = :id_libro');
    $stmt->bindParam(':id_usuario', $user_id);
    $stmt->bindParam(':id_libro', $book_id);
    $stmt->execute();
    $existingBook = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingBook) {
      // El llibre ja està en la llista del usuari, mostrar missatge i redireccionar
      header("Location: mislibros.php?added=false");
      exit();
    } else {
      // El llibre no està en la llista del usuari, afegir-ho a la bbdd
      $stmt = $conn->prepare('INSERT INTO mis_libros (id_usuario, id_libro) VALUES (:id_usuario, :id_libro)');
      $stmt->bindParam(':id_usuario', $user_id);
      $stmt->bindParam(':id_libro', $book_id);
      $stmt->execute();

      // Redireccionar novament a mislibros.php sense el parametre "add"
      header("Location: mislibros.php?added=true");
      exit();
    }
  }
} else {
  // L'usuari no està autenticat, redireccionar a inici de sessió
  header("Location: login.php");
  exit();
}


// Obtenir la llista de llibres asociats al usuari desde la bbdd
$conn = new PDO('mysql:host=localhost;dbname=readify', 'root', '');
$stmt = $conn->prepare('SELECT * FROM mis_libros INNER JOIN libros ON mis_libros.id_libro = libros.id WHERE mis_libros.id_usuario = :id_usuario');
$stmt->bindParam(':id_usuario', $user_id);
$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mostrar la informació dels llibres a la pàgina
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/style2.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!--Mostra el header amb el logo, la imatge del perfil de l'uusari i el botò de sortir-->
<div class="header">
<a href="../view/inici.php"><img src="../images/image.png"></a>
  <div class="espaisinici">
    <a href="logout.php" class="buttonLogOut">➲</a>
    <div class="user-anon2"> 
        <a href="../view/perfil.php"><img src="../images/usuarioanon.png" alt=""></a>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('.imagen').click(function() {
      var id = $(this).data('id');
      cargarVentanaDetalle(id);
    });
  });
  
  function cargarVentanaDetalle(id) {
  window.location.href = '../view/ventanadetalle.php?id=' + id;
}
</script>

<h1>Mis Libros</h1>

<?php
// Verificar si s'ha afegit un llibre correctament
if (isset($_GET['added'])) {
  $added = $_GET['added'];
  if ($added == 'true') {
    echo "<p>Libro agregado correctamente.</p>";
  } elseif ($added == 'false') {
    echo "<p>El libro ya está en tu lista.</p>";
  }
}

?>


<?php if (!empty($libros)) : ?>
    <?php foreach ($libros as $libro) : ?>
        <h3><?= $libro['titulo'] ?></h3><!--mostra el titol del llibre-->
        <img class='imagen' src="<?= $libro['imagen'] ?>" data-id="<?= $libro['id'] ?>" /><!--Mostra la imatge del llibre i guarda la id com atribut de les dades-->
    <?php endforeach; ?>
<?php else : ?>
    <p>No tienes ningún libro en tu lista</p><!--mostra missatge si no hi ha cap llibre a la llista-->
<?php endif; ?>


</html>