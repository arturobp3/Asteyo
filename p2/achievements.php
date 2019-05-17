<?php

namespace es\ucm\fdi\aw;
//Inicio del procesamiento
require_once __DIR__.'/includes/config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/index.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/meme.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Logros | Asteyo</title>
</head>

<body>

<div class="contenedor">

	<?php require("includes/comun/cabecera.php"); ?>

	<div class="principal">
		<?php require("includes/comun/sidebarIzq.php");?>

		<div class="contenido-index">
			<div class="logros">
				<h1>LOGROS DISPONIBLES</h1>
				<p>Si la imagen está en blanco y negro es que aún no lo has completado.</p>
				<!-- Inicio de la tabla -->
				<table>
					<thead>
						<tr>
							<th>Imagen</th>
							<th>Explicación logro</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php
								$resultado = Logros::comprobarLogros("nummg");
								
								if($resultado->num_rows > 0){
							?>
									<td><img src="assets/img/nummg.jpg" height="40px" width="40px" /></td>
									<td>Consigue 2 o más "me gusta" en tus memes.</td>
							<?php
								} else{
							?>
									<td><img src="assets/img/nnummg.jpg" height="40px" width="40px" /></td>
									<td>Consigue 2 o más "me gusta" en tus memes.</td>
							<?php
								}
							?>

						</tr>
						<tr>
							<?php
								$resultado = Logros::comprobarLogros("submemes");

								if($resultado->num_rows > 0){
							?>
									<td><img src="assets/img/submemes.jpg" height="40px" width="40px" /></td>
									<td>Sube 2 o más memes a la página.</td>
							<?php
								} else{
							?>
									<td><img src="assets/img/nsubmemes.png" height="40px" width="40px" /></td>
									<td>Sube 2 o más memes a la página.</td>
							<?php
								}
							?>
						</tr>
						<tr>
							<?php
								$resultado = Logros::comprobarLogros("comentavario");

								if($resultado->num_rows > 0){
							?>
									<td><img src="assets/img/comentavario.jpg" height="40px" width="40px" /></td>
									<td>Realiza dos o más comentarios en memes.</td>
							<?php
								} else{
							?>
									<td><img src="assets/img/ncomentavario.jpg" height="40px" width="40px" /></td>
									<td>Realiza dos o más comentarios en memes.</td>
							<?php
								}
							?>
						</tr>
					</tbody>
				</table>

			</div>
			
		</div>

	</div>

	<?php require("includes/comun/pie.php"); ?>

</div>

</body>
</html>