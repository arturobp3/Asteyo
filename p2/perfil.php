<?php

	require_once("includes/config.php");
	require_once("includes/usuario.php");

?>
<!DOCTYPE html>
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
			<link rel="stylesheet" type="text/css" href="assets/css/perfil.css" />
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
							$usuario = Usuario::buscaUsuario($_GET["userName"]);
							$uId = $usuario->id();
							$uUsername = $usuario->username();
							$uRol = $usuario->rol();
							$imgPerfil = "uploads/".$uId."/fotoPerfil.jpg";
							echo '<img id="img-perfil" src='.$imgPerfil.'>';
						?>
	                	</div>
	                	<div id="perfil">
							<?php
								echo "<div id='user-info'><p>Nombre: </p>".$uUsername."</div>";
								echo "<div id='user-info'><p>Rango: </p>".$uRol."</div>";

							?>
						</div>
					</div>
					<h3>Memes</h3>
					<div class="memes-perfil">
						<?php
							$rtMemes= Usuario::memes($uUsername);
							if($rtMemes){
								foreach ($rtMemes as $key => $value) {
									$meme = "uploads/".$uId."/".$value[2].".jpg";
									echo <<< END
									<div id="meme">
										<img id="imagen-meme"src=$meme>
										<div id ="meme-taInfo">
											<p> <b>$value[0]</b></p>
											<p>$value[1] <span style='color:red;'>\u{2764}</span> 0 <span>\u{1F4AC}</span> </p>
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

