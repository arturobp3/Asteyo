<?php

	require_once("includes/config.php");
	require_once("includes/usuario.php");

?>
<!DOCTYPE html>
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="css/estilo.css" />
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
					<a href='editarPerfil.php' class='edit'>Editar</a>
					<div id="foto">
						<?php
							$imgPerfil = "mysql/img/".$_SESSION["nombre"]."/fotoPerfil.jpg";
							echo "<img src=".$imgPerfil." width='100' height='115'>";
						?>
                		
                	</div>
                	<div id="perfil">
						<?php
							$usuario = Usuario::BuscaUsuario($_SESSION["nombre"]);
							//echo "Nombre: ".$_SESSION["nombre"];

							echo "<p>Nombre: ".$usuario->username()."</p>";
							$rango = $usuario->rol();
							echo "<p>Rango: ".$rango."</p>";

						?>
					</div>
					<div id="memes">
						<?php
							$rtMemes= Usuario::memes($usuario->username());
							foreach ($rtMemes as $key => $value) {
								echo "<img src=".$value." width='100' height='115'>";
							}
						?>
					</div>
				</div>

			</div>

		</body>
	</html>

