<?php
/**
 * @author abel i marc
 */
//Fem la connexió a la base de dades/*
try {
  $conn = new PDO('mysql:localhost;dbname=readify',"root","");
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>