<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="assets/style2.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<!--Posem el header amb el logo de readify -->
<div class="header">
  <a href="inici.php"><img src="./image.png" alt=""></a>
</div>
</head>

<!--Creem un requadre amb el text que mostra les instruccions del qr-->
<body class="bg">
  <div class="container">
    <br><br><br>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="panel-heading">
            <h1>Lector de Código de Barras</h1>
            <p>·Pulse -Abrir Cámara- para empezar escaneo</p>
            <p>·Asegúrese de que haya una imagen nítida</p>
            <p>·Finalmente pulse el botón -Escanea Código!-</p>
          </div>
          <hr>
          <!--Aqui es creen els botons on fa servir els mètodes per obrir la càmera, tancar-la o escanejar el codi-->
          <div id="camera-view"></div>
          <button type="button" class="btn btn-md btn-block btn-info" onclick="openCamera()">Abrir cámara</button>
          <button type="button" class="btn btn-md btn-block btn-info" onclick="closeCamera()">Cerrar cámara</button>
          <button type="button" class="btn btn-md btn-block btn-info" onclick="scanBarcode()">Escanea Código!</button>
          <p id="barcode-result"></p>
        </div>
      </div>
    </div>
  </div>


  <script>
    var videoElement;
    var stream;

  //Aquesta funció obre la càmera
    function openCamera() {
      var constraints = { video: true };

      // Accedir a la càmera de l'usuari
      navigator.mediaDevices.getUserMedia(constraints)
        .then(function(mediaStream) {
          stream = mediaStream;
          videoElement = document.createElement('video');
          videoElement.srcObject = stream;
          videoElement.autoplay = true;

          // Mostrar la vista de la càmera en el document
          var cameraView = document.getElementById('camera-view');
          cameraView.innerHTML = '';
          cameraView.appendChild(videoElement);


         
          var cameraMessage = document.getElementById("camera-message");
          cameraMessage.style.display = "none";


         // Iniciar la detecció de codis de barres
          startBarcodeDetection();
        })
        .catch(function(error) {
          console.error('Error accessing camera:', error);
        });
    }

    //Aquesta funció tanca la càmera
    function closeCamera() {
      if (stream) {
        var tracks = stream.getTracks();
        tracks.forEach(function(track) {
          track.stop();
        });


        videoElement.srcObject = null;


        var cameraView = document.getElementById('camera-view');
        cameraView.innerHTML = '';


        var cameraMessage = document.getElementById("camera-message");
        cameraMessage.style.display = "block";


       // Aturar la detecció de codis de barres
        stopBarcodeDetection();
      }
    }

    //Aquesta funció s'utilitza per detectar un codi de barres en temps real
    function startBarcodeDetection() {
      Quagga.init({
        inputStream: {
          name: "Live",
          type: "LiveStream",
          target: videoElement
        },
        decoder: {
          readers: ["ean_reader"] 
        }
      }, function(err) {
        if (err) {
          console.error('Error initializing Quagga:', err);
          return;
        }
        Quagga.start();
      });

      //Quan detecta el codi de barres, guarda el resultat en una variable
      Quagga.onDetected(function(result) {
        var barcodeResult = document.getElementById("barcode-result");
        barcodeResult.innerText = result.codeResult.code;
       
      });
    }

    //Es tanca el moment de detectar el codi de barres
    function stopBarcodeDetection() {
      Quagga.stop();
    }

    //S'inicia el moment per detectar el codi de barres
    function scanBarcode() {
      Quagga.start();
    }
  </script>
</body>
</html>
