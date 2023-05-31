<?php
/**
 * @author abel i marc
 */
session_start();//Iniciem sesió
require '../model/database.php';//Incluim l'arxiu per establir la conexió amb la bbdd

if (isset($_POST['user_id']) && isset($_POST['libro_id'])) {
  $user_id = $_POST['user_id'];// S'obtié el valor del camp 'user_id' enviat mitjançant el métode POST i s'asigna a la variable $user_id
  $libro_id = $_POST['libro_id'];// S'obtié el valor del camp 'libro_id' enviat mitjançant el métode POST i s'asigna a la variable $libro_id

  //preparació i execcució de la consulta per actualitzar la taula libros
  $updateStmt = $conn->prepare('UPDATE libros SET es_de_pago = 0, user_id = ? WHERE id = ?');
  $updateStmt->bind_param('ii', $user_id, $libro_id);
  
  if ($updateStmt->execute()) {//si s'actualitza correcte
    echo 'success';//mostra un missatge success
    header("Location: ../model/leerlibro.php?id=$id");//es redrigeix a leerlibro passant l'id del llibre com a parametre en la url
  } else {
    echo 'error';//si l'actualització falla mostra un missatge d'error
  }
} else {
  echo 'error';//si no es proporcionen els anteriors camps user_id i libro_id donarà missatge erroni
}
?>
