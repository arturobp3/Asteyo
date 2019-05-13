<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/FormularioSubirMeme.php");

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="assets/css/general.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/formularios.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/index.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Sube tu meme | Asteyo</title>
</head>

<body>

<div class="contenedor">

    <?php require("includes/comun/cabecera.php"); ?>

    <div class="principal">

        <?php require("includes/comun/sidebarIzq.php");?>

        <div class="contenido-index" id="subida">
            <h2 style="font-family: impact;">AÑADE TU MEME</h2>

			<a href="subirMeme.php" class="subir"> SUBIR DESDE</br>TU ORDENADOR </a>
			<a href="crearMeme.php" class="subir"> CREA TU MEME</a>
        
        </div>

    </div>

    <?php require("includes/comun/pie.php"); ?>
    
</div>

</body>
</html>