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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sube tu meme | Asteyo</title>
</head>

<body>

<div class="contenedor">

    <?php require("includes/comun/cabecera.php"); ?>

    <div class="principal">

        <?php require("includes/comun/sidebarIzq.php");?>

        <div class="contenido-formularios">
            <h2>SUBE TU MEME</h2>

        <?php
            $formulario = new formularioSubirMeme("subirMeme", array( 'action' => 'subirMeme.php'));
            $formulario->gestiona();

        ?>
        </div>

    </div>

    <?php require("includes/comun/pie.php"); ?>
    
</div>

</body>
</html>