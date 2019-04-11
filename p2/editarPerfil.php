<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/formularioEdit.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/estilo-general.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/estilo-formularios.css" />
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
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
					<h2>Editar perfil</h2>
					<h4>Solo rellena los campos que quieras modificar</h4>

					<?php
						$formulario = new formularioEdit("edit", array( 'action' => 'editarPerfil.php'));
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