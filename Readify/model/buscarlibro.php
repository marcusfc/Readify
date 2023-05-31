<?php
/**
 * @author abel i marc
 */
require 'database.php';//Incluim l'arxiu per establir la conexió amb la bbdd

if (isset($_POST['search'])) {
  $searchTerm = $_POST['search'];// Verifiquem si s'ha enviat el formulari amb el camp 'search' i asignem valor a la variable $searchTerm

  // Executar la consulta per buscar el llibre en la base de dades
  $stmt = $conn->prepare('SELECT id, titulo FROM libros WHERE titulo LIKE :searchTerm OR Autor LIKE :searchTerm');
  $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
  $stmt->execute();
  $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Retornem resultats de la cerca en format JSON
  echo json_encode($books);
}
?>
