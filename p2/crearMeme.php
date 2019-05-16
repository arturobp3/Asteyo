<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/FormularioSubirMeme.php");

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="assets/css/general.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/formularios.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="./assets/js/memeMaker.js"></script>
    <title>Crea tu meme | Asteyo</title>
    

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/3.6.1/firebase.js"></script>
	<script>
		
		// Initialize Firebase
	  var config = {
		apiKey: "AIzaSyBGcIVuJwpYmr5Eu81UZVNvDlHiI-pPV9Y",
		authDomain: "chatfirebase-73f27.firebaseapp.com",
		databaseURL: "https://chatfirebase-73f27.firebaseio.com",
		storageBucket: "chatfirebase-73f27.appspot.com",
		messagingSenderId: "1085267677865"
	  };
	  firebase.initializeApp(config);
	  //Variable con acceso a datos 
	  var TablaDeBaseDatos= firebase.database().ref('memes');
		
	</script>
	
    
</head>

<body>

<div class="contenedor">

    <?php require("includes/comun/cabecera.php"); ?>

    <div class="principal">

        <?php require("includes/comun/sidebarIzq.php");?>

        <div class="contenido-formularios">
            <div class="container">
				<div class="row">
					<div>

						<div class="col-md-9 text-center">
	
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- Header -->
								<ins class="adsbygoogle"
								style="display:inline-block;width:728px;height:90px"
								data-ad-client="ca-pub-4331617637495482"
								data-ad-slot="2764029251"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>

						</div>
					</div>
				</div>
        
		<div class="row">
            <div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">Configuración del Meme</div>
						<div class="panel-body">
							Texto Arriba:
							<input type="text" id="txtTextoArriba" onkeyup="GenerarMeme()" value="Arriba" class="form-control" />
							Texto Abajo:
							<input type="text" id="txtTextoAbajo" onkeyup="GenerarMeme()" value="Abajo" class="form-control" />
							Imagen: 
							<input type="file" name="fileMeme" id="fileMeme" class="form-control">
							Titulo:
							<input type="text" id="titulo" value="Titulo" class="form-control" />
							Hashtags:
							<input type="text" id="hashtags" value="hashtags" class="form-control" />
						</div>
                </div>
                
                
                <div class="panel panel-default">
				
                    <div class="panel-heading">Nuestras plantillas</div>
                    
					<div class="panel-body">
						<?php
							$dir = "./assets/templates";
							$explorar = scandir($dir);
							
							$total_archivos = count($explorar)-2;
							

							for ($i = 0; $i<$total_archivos; $i++) {
								$j = $i+1;
								echo '<div class="col-xs-2 col-md-6">
                            			<a href="#" class="thumbnail">
                                			<img src="./assets/templates/meme'. $j .'.jpg"  class="imgthumbnail">
                            			</a>
									 </div>';
								
								
							}
						?>
													
					</div>
                </div>
                
            </div>
            
            <div class="col-md-8">
                <div class="col-md-12 text-center">
			<div class="panel panel-default">
			<div class="panel-heading">Salida del Meme</div>
                <div class="panel-body">
                <img src="meme5.jpg" id="image" style="display:none; width: 100%; height: auto" />
                    <canvas id="canvas" style="width: 100%; height: auto"></canvas>
                
                </div>
                    </div>
                    <a id="btnDescargar" value="Descargar" class="btn btn-danger">Descargar meme </a>
					<a id="btnSubir" value="Subir" class="btn btn-danger">Subir meme</a>
                </div>

				
                
            </div>
        </div>
    </div>
    <script src="./assets/js/memeMaker.js"></script>
    <script>
		function downloadCanvas(link, canvasId, filename) {
			link.href = document.getElementById(canvasId).toDataURL();
			link.download = filename;
		}
		document.getElementById('btnDescargar').addEventListener('click', function() {
			downloadCanvas(this, 'canvas', 'miMeme.png');
		}, 
		false);
    </script>
    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  ga('create', 'UA-74824848-1', 'auto');
	  ga('send', 'pageview');
	</script>
        
        </div>

    </div>

    <?php require("includes/comun/pie.php"); ?>
    
</div>

</body>
</html>