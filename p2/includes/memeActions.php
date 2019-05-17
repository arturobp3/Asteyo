<?php
require_once('config.php');
require_once('Aplicacion.php');
require_once('usuario.php');
require_once('meme.php');


if($_POST['accion'] === "delete"){
    $meme = Meme::buscaMeme($_POST['idMeme']);
    $success = Meme::eliminar($meme);
    if ($success) {
        echo json_encode(array('success' => true));
    }
    else {
        echo json_encode(array('success' => false));
    }
}