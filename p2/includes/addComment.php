<?php

//Este fichero se encarga de guardar la información recibida por AJAX
//del comentario, en la base de datos

require_once("./config.php");
require_once('./aplicacion.php');


$error = '';
$html = '';

$hoy = date("Y-m-d H:i:s");


if(empty($_POST['comentario'])){
    $error = 'Debes escribir un comentario primero';
}
else{

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


    $query=sprintf("INSERT INTO comments(id_autor, id_meme, texto, c_date)
                    VALUES('%s', '%s', '%s', '%s')",
                        $conn->real_escape_string($id_autor),
                        $conn->real_escape_string($id_meme),
                        $conn->real_escape_string($comentario),
                        $conn->real_escape_string($hoy)
    );

    if ( $conn->query($query) ){
        $html = "<div id='cajaComentario'>
                    <p id='user'>".$_SESSION['nombre']."</p>
                    <p id='fecha'>".$hoy."</p>
                    <p id='comentario'>".$comentario."</p>";

                    if(isset($_SESSION['login']) && $_SESSION['esModerador']){
                        $html .= " 
                        <div id='botones'>
                            <a onclick='borrarComentario($conn->insert_id)'>
                                Eliminar
                            </a>
                        </div>";
                    }
                    //Si es usuario puede reportarlo
                    else if(isset($_SESSION['login']) && $_SESSION['esUser']){
                        $html .= "
                        <div id='botones'>
                            <a onclick='reportarComentario($conn->insert_id)'>
                                Reportar
                            </a>
                        </div>";
                    }
            $html .= "</div>";
    } 
    else {
        $error = "Ha habido un error al guardar tu comentario";

    }
}

//Codificamos la información
$data = array(
    'error' => $error,
    'html' => $html
);

//La enviamos en forma de JSON al cliente
echo json_encode($data);