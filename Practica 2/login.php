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
	//Cabecera y barra izquierda
?>

	<div id="contenido">
		<h1>Acceso al sistema</h1>

		<?php
			$formulario = new formularioLogin("login");
			$formulario->gestiona();
		?>

	</div>

<?php
	//barra derecha y pie de página
?>


</div>

</body>
</html>