<?php
/**
 * @author abel i marc
 */
session_start();//Iniciem sesió
require '../model/database.php';//Incluim l'arxiu per establir la conexió amb la bbdd


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $records = $conn->prepare('SELECT id, name, email,password,target FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);// Associem el valor de 'user_id' com a paràmetre a la consulta
  $records->execute();//Executem la consulta
  $results = $records->fetch(PDO::FETCH_ASSOC);//obtenim els resultats de la consulta

  $user = null;

  //Passem els resultats a la variable user
  if (count($results) > 0) {//comprobem si hi han resultats
    $user = $results;//Assigenm els resultats a la variable user
  }
}
  ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/style2.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.2.0/html5-qrcode.min.js"></script>
<title>QR Code</title>
<!--Posem el header amb el logo, el usuari del perfil i el botò de sortir-->
<div class="header">
<a href="inici.php"><img src="../images/image.png"></a>
  <div class="espaisinici">
    <a href="../controller/logout.php" class="buttonLogOut">➲</a>
    <div class="user-anon2">
    <a href="perfil.php"><img src="../images/usuarioanon.png" alt=""></a>
    </div>
  </div>
</div>
</head>
<body>


<h1>Lector QR</h1>


<!-- QR SCANNER CODE BELOW  -->
<div id="reader-container">
  <div id="reader"></div>
  <div style="margin-top: 20px;">
    <h4>Accede a los detalles del libro: </h4>
    <div id="result">
      <button id="detail-button" onclick="handleDetailButtonClick()">Detalle libro</button>
    </div>
  </div>
</div>


<script>
var scannedLink = ''; // Variable per a guardar l'enllaç escanejat



/**
 * Funció per a controlar el clic en el botó "Detalle libro"
 *
 * @return void
 */
function handleDetailButtonClick() {
  if (scannedLink) {
    window.location.href = scannedLink; // Redirigeix al enllaç guardat
  }
}


document.getElementById("detail-button").style.display = 'none';

/**
 * Quan l'escaneij es exitós, mostra el botó i guarda l'enllaç
 */
function onScanSuccess(qrCodeMessage) {
  scannedLink = qrCodeMessage; // Guarda l'enllaç escanejat
  var detailButton = document.getElementById("detail-button");
  detailButton.disabled = false; // Habilita el botó
  detailButton.style.display = 'inline-block'; // Mostra el botó
}
 
/**
 * Quan l'escaneij no es exitós, controla l'error
 */
function onScanError(errorMessage) {
  // Controla l'error d'escaneitj
}


// Configuració del scanner QR
var html5QrCodeScanner = new Html5QrcodeScanner("reader", {
  fps: 10,
  qrbox: 250
});


// Renderitza scanner QR
html5QrCodeScanner.render(onScanSuccess, onScanError);


</script>
<!--Mostrem el footer amb el nom de l'usuari actiu-->
</body>
</html>


