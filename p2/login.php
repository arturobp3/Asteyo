<?php

//Inicio del procesamiento

require_once("includes/config.php");
require_once("includes/FormularioLogin.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/formularios.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Iniciar Sesión | Asteyo</title>
</head>

<body>

	<div id="contenedor">

		<?php

			require("includes/comun/cabecera.php");

		?>

			<div class="principal">

				<?php require("includes/comun/sidebarIzq.php"); ?>

				<div class="contenido-formularios">

					<?php
						$formulario = new formularioLogin("login", array( 'action' => 'login.php'));
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