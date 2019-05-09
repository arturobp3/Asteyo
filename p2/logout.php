<?php

//Inicio del procesamiento
require_once("includes/config.php");

//Doble seguridad: unset + destroy
unset($_SESSION["login"]);
unset($_SESSION["esAdmin"]);
unset($_SESSION["esUser"]);
unset($_SESSION["esModerador"]);
unset($_SESSION["nombre"]);


session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Logout | Asteyo</title>
</head>

<body>

	<div class="contenedor">

		<?php require("includes/comun/cabecera.php"); ?>

		<div class="principal">

			<?php require("includes/comun/sidebarIzq.php"); ?>

			<div id="contenido">
				<h1>Hasta pronto!</h1>
			</div>

		</div>

		<?php
			require("includes/comun/pie.php");
		?>

	</div>

</body>
</html>
