<?php

	require_once("includes/config.php");
	require_once("includes/usuario.php");

?>
<!DOCTYPE html>
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="assets/css/estilo-general.css" />
			<link rel="stylesheet" type="text/css" href="assets/css/estilo-perfil.css" />
			<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>Perfil | Asteyo</title>
		</head>
		<body>
			<?php

			require("includes/comun/cabecera.php");

		?>

			<div class="principal">

				<?php require("includes/comun/sidebarIzq.php"); ?>

				<div id="contenido">						
					<a href='editarPerfil.php' id='edit'>Editar</a>
					<div id="panel-perfil">
						<div id="foto">
						<?php
							$imgPerfil = "uploads/".$_SESSION["nombre"]."/fotoPerfil.jpg";
							echo '<img id="img-perfil" src='.$imgPerfil.'>';
						?>
	                	</div>
	                	<div id="perfil">
							<?php
								$usuario = Usuario::buscaUsuario($_SESSION["nombre"]);
								//echo "Nombre: ".$_SESSION["nombre"];

								echo "<div id='user-info'><p>Nombre: </p>".$usuario->username()."</div>";
								echo "<div id='user-info'><p>Rango: </p>".$usuario->rol()."</div>";

							?>
						</div>
					</div>
					<h3>Memes</h3>
					<div class="memes-perfil">
						<?php
							$rtMemes= Usuario::memes($usuario->username());
							if($rtMemes){
								foreach ($rtMemes as $key => $value) {
									$meme = "uploads/".$usuario->username()."/".$value[2].".jpg";
									echo <<< END
									<div class="responsive">
										<div id="meme">
											<img id="imagen-meme"src=$meme>
											<p>Título: $value[0]</p>
											<p>$value[1] Me Gusta</p>
										</div>
									</div>
									END;
								}
							}
						?>
					</div>
				</div>

			</div>

		<?php require("includes/comun/pie.php"); ?>
		</body>
	</html>

