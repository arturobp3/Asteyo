<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/FormularioAdmin.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/formularios.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Registro | Asteyo</title>
</head>

<body>

	<div id="contenedor">

		<?php
			require("includes/comun/cabecera.php");
		?>

			<div class="principal">

				<?php require("includes/comun/sidebarIzq.php"); ?>

				<div class="contenido-formularios">
					<h2>GESTIONAR MODERADORES</h2>

					<?php
						$formulario = new formularioAdmin("registro", array('action' => 'admin.php'));
						$formulario->gestiona();
					?>
				</div>


			</div>

		<?php
			require("includes/comun/pie.php");
		?>

	</div>

</body>
</html>