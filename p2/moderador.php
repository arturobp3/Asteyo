<?php

namespace es\ucm\fdi\aw;
//Inicio del procesamiento

require_once __DIR__.'/includes/config.php';

$app->doInclude("/vistaReports.php");
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/index.css" />
	<!--script type="text/javascript" src="./assets/js/reports.js"></script-->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Reportes | Asteyo</title>
</head>

<body>

<div class="contenedor">

	<?php require("includes/comun/cabecera.php"); ?>

	<div class="principal">
		<?php require("includes/comun/sidebarIzq.php");?>

		<div class="contenido-reports">
		<h2>Gestión del moderador</h2>
		<?php
			echo "<div id='caja'>
					<h3>Reports de Usuarios</h3>";
					getUserReports();
			echo "</div>";
			echo "<div id='caja'>
					<h3>Reports de Comentarios</h3>";
					getCommentReports();
			echo	"</div>";
			echo "<div id='caja'>
					<h3>Reports de Memes</h3>";
					getMemeReports();
			echo "</div>";
			
        ?>	
		</div>

	</div>

	<?php require("includes/comun/pie.php"); ?>

</div>

</body>
</html>