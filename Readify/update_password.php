<?php
session_start();

/*Comprovem que hi ha una sessió activa*/
require 'database.php';

if (isset($_SESSION['user_id'])) {
  if (isset($_POST['current_password']) && isset($_POST['new_password'])) {
    $user_id = $_SESSION['user_id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
/*Aqui fem la consulta per agafar la id i saber l'usuari que es, preprarem la consulta*/
    $records = $conn->prepare('SELECT id, name, email, password, target FROM users WHERE id = :id');
    $records->bindParam(':id', $user_id);
    $records->execute();
    $user = $records->fetch(PDO::FETCH_ASSOC);

    /*Comprovem que la contrasenya de l'usuari es correcta i fem el hash perquè no se sàpiga la contrasenya*/
    if (password_verify($currentPassword, $user['password'])) {
      $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

      /*Actualitzem la contrasenya amb la següent consulta*/
      $updatePassword = $conn->prepare('UPDATE users SET password = :password WHERE id = :id');
      $updatePassword->bindParam(':password', $hashedPassword);
      $updatePassword->bindParam(':id', $user_id);
      $updatePassword->execute();
//Aqui fem que una vegada executat, vagi al perfil i mostri missatge si s'ha pogut canviar la contrasenya o no
      header('Location: perfil.php?message=Contraseña actualizada con éxito.');
      exit;
    } else {
      header('Location: perfil.php?message=Error, no se ha podido cambiar la contraseña');
      exit;
    }
  }
}
?>