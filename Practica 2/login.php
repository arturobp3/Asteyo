<?php

//Inicio del procesamiento

require_once("includes/config.php");
require_once("includes/formularioLogin.php");

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilos/estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login</title>
</head>

<body>

<div id="contenedor">

<?php
	require("includes/comun/cabecera.php");
	require("includes/comun/sidebarIzq.php");
?>

	<div id="contenido">
		<h1>Acceso al sistema</h1>

		<?php
			$formulario = new formularioLogin("login");
			$formulario->gestiona();
		?>

	</div>

<?php
	require("includes/comun/sidebarDer.php");
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>