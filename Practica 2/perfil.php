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

					<?php
						$usuario = Usuario::BuscaUsuario($_SESSION["nombre"]);
						//echo "Nombre: ".$_SESSION["nombre"];
						echo "Nombre: ".$usuario->username();
						$rango = $usuario->rol();
						echo "Rango: ".$rango;

					?>

				</div>

			</div>

		</body>
	</html>

