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
			<script src="./assets/js/jquery-3.4.1.min.js"></script>
			<script type="text/javascript" src="./assets/js/reports.js"></script>
			<title>Perfil | Asteyo</title>
		</head>
		<body>
			<?php

			require("includes/comun/cabecera.php");

		?>

			<div class="principal">

				<?php 
					require("includes/comun/sidebarIzq.php");

					$usuario = Usuario::buscaUsuario($_GET["userName"]);
					$uUsername = $usuario->username();
				?>

				<div id="contenido">
				
					<?php

						if(isset($_SESSION['login']) && $_SESSION['nombre'] === $uUsername){
							echo "<a href='editarPerfil.php' id='edit'>Editar</a>";
						}
					?>
					<div id="panel-perfil">
						<div id="foto">
						<?php
							$uId = $usuario->id();
							$uRol = $usuario->rol();
							$imgPerfil = "uploads/".$uId."/fotoPerfil.jpg";
							echo '<img id="img-perfil" src='.$imgPerfil.'>';
						?>
	                	</div>
	                	<div id="perfil">
							<?php
								echo "<div id='user-info'><p>Nombre: </p>".$uUsername."</div>";
								echo "<div id='user-info'><p>Rango: </p>".$uRol."</div>";
								
								if(isset($_SESSION['login']) && ($_SESSION['esUser'] || $_SESSION['esModerador'])
									&& $_SESSION['nombre'] !== $uUsername){
									echo "
									<div class='botones'>
										<a onclick='openMenuReport(\"#menuReportUser\")'>Reportar usuario </a>
										<ul class='subMenu' id='menuReportUser'>
											<li><a onclick='reportarUsuario(\"{$uUsername}\", 1)'>Foto de perfil ofensiva</a></li>
											<li><a onclick='reportarUsuario(\"{$uUsername}\", 2)'>Nombre inapropiado</a></li>
											<li><a onclick='reportarUsuario(\"{$uUsername}\", 3)'>Bot</a></li>
										</ul>
									</div>
									<p id='mensajeReport'></p>";
								}

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
									$info_meme = Meme::getMeme($value[2]);
									$comments = $info_meme->comentarios();
									$num_comments = sizeof($comments);
									echo <<< END
									<div id="meme">
										<img id="imagen-meme"src=$meme>
										<div id ="meme-taInfo">
											<p> <b>$value[0]</b></p>
											<p>$value[1] <span style='color:red;'>\u{2764}</span> $num_comments <span>\u{1F4AC}</span> </p>
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

