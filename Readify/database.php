<?php

$server = 'localhost:3307';
$username = 'root';
$password = '';
$database = 'readify';


try {
  $conn = new PDO('mysql:host=localhost;dbname=readify',"root","");
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}


?>
