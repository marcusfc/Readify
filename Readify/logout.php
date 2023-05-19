<?php
//Mètodes per iniciar sessió, session_unset elimina els resultats de les variables que emmagatzemen dades de la sessió.
  session_start();

  session_unset();

  //Elimina la sessió actual i les variables d'incii de sessió es reinicien
  session_destroy();
//Aqui torna al index
  header('Location: ./index.php');
?>