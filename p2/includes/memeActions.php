<?php

namespace es\ucm\fdi\aw;

require_once __DIR__.'/config.php';

if($_POST['accion'] === "delete"){
	  
    $meme = Meme::getMeme($_POST['idMeme']);
    $success = Meme::eliminar($meme);
    if ($success) {
        echo json_encode(array('success' => true));
    }
    else {
        echo json_encode(array('success' => false));
    }
}