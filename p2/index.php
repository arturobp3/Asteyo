<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/meme.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/index.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Inicio | Asteyo</title>
</head>

<body>

<div class="contenedor">

	<?php require("includes/comun/cabecera.php"); ?>

	<div class="principal">
		<?php require("includes/comun/sidebarIzq.php");?>

		<div class="contenido-index">
		<?php

			$result;
			if(isset($_GET['buscar'])){
				//Se ha recibido una petición de busqueda de memes por el buscador

				$result = Meme::searchMemeHashtag($_GET['buscar']);
			}
			else{
				//No se ha recibido nada y por tanto obtenemos los memes ordenados por fecha
				$result = Meme::lastMemes();
			}


			if($result === false){
				echo "<h1> ¡No se han encontrado memes! </h1>";
			}
			else{

				foreach ($result as $meme) {
					echo
					'<a class="memes" href="./meme.php?name='.$meme['username'].'&id='.$meme['id'].'"">
						<div id="meme">
							<div id="meme-title">
								<p>'.$meme['nameMeme'].'</p>
							</div>
							<div id="meme-container">
								<img id="img-meme" src="uploads/'.$meme['username'].'/'.$meme['id'].'.jpg"/>
							</div>
							<div id="meme-info">
								<div id="user-info">
									<img id="user-profile-picture" src="./uploads/'.$meme['username'].'/fotoPerfil.jpg"/>
									<p> by '.$meme['username'].'</p>
								</div>
								<p>'.$meme['numLikes'].' me gusta</p>
							</div>
						</div>
					</a>';	
				}
			}
        ?>	
		</div>

	</div>

	<?php require("includes/comun/pie.php"); ?>

</div>

</body>
</html>