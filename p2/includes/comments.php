<?php

//Este fichero se encarga de guardar la información recibida por AJAX
//del comentario, en la base de datos

require_once("./config.php");
require_once('./Aplicacion.php');
require_once('./Comentarios.php');


$error = '';
$html = '';

$hoy = date("Y-m-d H:i:s");


if($_POST['accion'] === "añadir" && empty($_POST['comentario'])){
    $error = 'Debes escribir un comentario primero';
}
else{

    /*------------OBTENEMOS INFORMACION DE LA PETICIÓN AJAX---------------*/
    $accion = isset($_POST['accion']) ? $_POST['accion'] : null;
    $id_meme = isset($_POST['id_meme']) ? $_POST['id_meme'] : null;
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : null;
    $nombreAutor = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
    $id_comment = isset($_POST['id_comment']) ? $_POST['id_comment'] : null;
    $autorComentario = isset($_POST['autorComentario']) ? $_POST['autorComentario'] : null;

    $app = Aplicacion::getInstance();
    $conn = $app->conexionBD();

    $consultaID = sprintf("SELECT U.id
                    FROM users U
                    WHERE U.username = '%s'",
                $conn->real_escape_string($nombreAutor)
    );

    $id_autor = $conn->query($consultaID);
    $id_autor = $id_autor->fetch_assoc()['id'];//ID del usuario de la sesion

    $consultaID = sprintf("SELECT U.id
                    FROM users U
                    WHERE U.username = '%s'",
                $conn->real_escape_string($autorComentario)
    );

    $id_autor_comment = $conn->query($consultaID);
    $id_autor_comment = $id_autor_comment->fetch_assoc()['id'];//ID del usuario del comentario
    /*--------------------------------------------------------------------*/

    $comentario = new Comentarios($id_autor, $id_meme, $comentario, $hoy);


    switch($accion){
        case "añadir": $rs = $comentario->addComment(); break;
        case "borrar": $rs = $comentario->deleteComment($id_comment); break;
        case "reportar": $rs = $comentario->reportComment($id_autor_comment, $id_autor,
                        $id_comment, $_POST['cause']); break;
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