<?php
/**
 * @author abel i marc
 *
 */
$server = 'localhost:3307'; // Servidor bbdd
$username = 'root';//nom usuari bbdd
$password = '';//contrasenya bbdd
$database = 'readify';//nom bbdd


try {
  $conn = new PDO('mysql:host=localhost;dbname=readify',"root",""); //establim conexió utilitzant PDO
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());//si dona error ens mostrarà un missatge d'error
}
?>
