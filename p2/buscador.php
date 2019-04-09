<?php
	//Inicio del procesamiento
	require_once("../includes/hashtag.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inicio | Asteyo</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" type="text/css" href="assets/css/estilo.css">
</head>
<body>

	<div class="contenedor">

		<?php require("comun/cabecera.php"); ?>

		<main>

			<?php 
				require("comun/sidebarIzq.php");
				//Obtenemos gracias al controlador los productos deseados
			
				$result = $_POST['buscar'];

				//Buscar los memes relacionados con el hashtag buscado
				Hashtag::searchMemeHashtag($result);


				if(empty($result)){
					echo "<h1 class='mensaje'> No se han encontrado resultados</h1>";
				}
			
			?>

			<div class="content">

				<?php
					foreach ($result as $key => $value) {

						echo "<a id='meme' href='./meme.php?id=".$value->id()."'>


								MEMES BUSCADOS


							</a>";
					}
				?>

				
			</div>

		</main>

		<?php require("comun/pie.php"); ?>
		

	</div>

</body>
</html>