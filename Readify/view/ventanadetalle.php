<?php
/** 
 * @author abel i marc
 * 
 */
session_start();//Iniciem sesió
require '../model/database.php';//Incluim l'arxiu per establir la conexió amb la bbdd

if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, name, email, password, target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);// Associem el valor de 'user_id' com a paràmetre a la consulta
  $records->execute();//Executem la consulta
  $results = $records->fetch(PDO::FETCH_ASSOC);//obtenim els resultats de la consulta

  $user = null;
  
  if (count($results) > 0) {//comprobem si hi han resultats
    $user = $results;//Assigenm els resultats a la variable user
  }
}

$id = $_GET['id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "readify";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM libros WHERE id = $id";
$result = $conn->query($sql);

$book = false; // Variable para verificar si el usuario ha comprado el libro

if (isset($_SESSION['user_id'])) {
  // Verificar si el usuario ha comprado el libro
  $user_id = $_SESSION['user_id'];
  $stmt = $conn->prepare('SELECT * FROM mis_libros WHERE id_usuario = ? AND id_libro = ?');
  $stmt->bind_param('ii', $user_id, $id);
  $stmt->execute();
  $stmt->store_result();
  $book = ($stmt->num_rows > 0);
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

<div class="header">
  <a href="inici.php"><img src="../images/image.png"></a>
  <div class="espaisinici">
    <a href="../controller/logout.php" class="buttonLogOut">➲</a>
    <div class="user-anon2">
      <a href="perfil.php"><img src="../images/usuarioanon.png" alt=""></a>
    </div>
  </div>
</div>

<?php
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo "<h1>" . $row["titulo"] . "</h1>";
  echo "<img class='imagen' src=" . $row["imagen"] . ">";
  echo "<div class='details'>";
  echo "<p>" . $row["resumen"] . "</p>";
  echo "</div>";
  echo "<p><strong>Fecha de Publicación:</strong> " . $row["fechapubli"] . "</p>";
  echo "<p><strong>Género:</strong> " . $row["genero"] . "</p>";
  echo "<p><strong>ISBN:</strong> " . $row["ISBN"] . "</p>";
  echo "<p><strong>Número de páginas:</strong> " . $row["numpag"] . "</p>";
  echo "<p><strong>Autor:</strong> " . $row["Autor"] . "</p>";

  if ($row["es_de_pago"] == 1 && !$book) {
    // El libro es de pago y el usuario no lo ha comprado
    ?>
    <button onclick="confirmarcompra()" class="button"><?= $row["precio"] ?> 📚</button>
    <?php
  } else {
    // El libro es gratuito o el usuario ya lo ha comprado
    ?>
    <a href="../model/leerlibro.php?id=<?= $id ?>" class="button">Leer libro</a>
    <a href="../controller/mislibros.php?id=<?= $id ?>&add=true" class="button">Añadir 📚</a>
    <?php
  }
} else {
  echo "No se encontró ningún registro con ese ID";
}
?>


<script>
  /**
   * Funció per confirmar compra
   *
   * @return void
   */
  function confirmarcompra() {
    if (confirm("¿Estás seguro de realizar la compra?")) {
      window.location.href = "../controller/mislibros.php?id=<?= $id ?>&add=true";
    } else {
      event.preventDefault();
    }
  }
</script>
<br>
<br>
<br>
<br>
<br>
<div class="footer">
  <p>Has iniciado sesión como <?= $user['name']; ?> </p>
</div>
</body>
</html>
