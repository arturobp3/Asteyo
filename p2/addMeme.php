<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/formularioSubirMeme.php");

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="assets/css/general.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/formularios.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sube tu meme | Asteyo</title>
</head>

<body>

<div class="contenedor">

    <?php require("includes/comun/cabecera.php"); ?>

    <div class="principal">

        <?php require("includes/comun/sidebarIzq.php");?>

        <div class="contenido-formularios">
            <h2>AÑADE TU MEME</h2>
			
			<a href="subirMeme.php"> Subir desde tu ordenador </a>
			<a href="crearMeme.php"> Crea tu meme </a>
        
        </div>

    </div>

    <?php require("includes/comun/pie.php"); ?>
    
</div>

</body>
</html>