<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/formularioSubirMeme.php");

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Subir Meme</title>
</head>

<body>

<div class="contenedor">

<?php require("includes/comun/cabecera.php"); ?>

<div class="principal">

	<?php require("includes/comun/sidebarIzq.php");?>

	<div id="contenido">

        <?php
            $formulario = new formularioSubirMeme("subirMeme");
            $formulario->gestiona();
        ?>


	</div>

</div>

<?php require("includes/comun/pie.php"); ?>


</div>

</body>
</html>