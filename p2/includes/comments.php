<?php

//Este fichero se encarga de guardar la información recibida por AJAX
//del comentario, en la base de datos

require_once("./config.php");
require_once('./Aplicacion.php');
require_once('./Comentarios.php');


$error = '';
$html = '';

$hoy = date("Y-m-d H:i:s");


if(empty($_POST['comentario'])){
    $error = 'Debes escribir un comentario primero';
}
else{

    /*------------OBTENEMOS INFORMACION DE LA PETICIÓN AJAX---------------*/
    $accion = $_POST['accion'];
    $id_meme = $_POST['id_meme'];
    $comentario = $_POST['comentario'];
    $nombreAutor = $_SESSION['nombre'];

    $app = Aplicacion::getInstance();
    $conn = $app->conexionBD();

    $consultaID = sprintf("SELECT U.id
                    FROM users U
                    WHERE U.username = '%s'",
                $conn->real_escape_string($nombreAutor)
    );

    $id_autor = $conn->query($consultaID);
    $id_autor = $id_autor->fetch_assoc()['id'];
    /*--------------------------------------------------------------------*/

    $comentario = new Comentarios($id_autor, $id_meme, $comentario, $hoy);

    switch($accion){
        case "añadir": $rs = $comentario->addComment(); break;
        case "borrar": $rs = $comentario->deleteComment(); break;
        case "reportar": $rs = $comentario->reportComment(); break;
        default: $rs = false; break;
    }
    
    if($rs !== false){
        $html = $rs;
    }
    else {
        $error = "Ha habido un error al procesar el comentario";
    }
}

//Codificamos la información
$data = array(
    'error' => $error,
    'html' => $html
);

//La enviamos en forma de JSON al cliente
echo json_encode($data);