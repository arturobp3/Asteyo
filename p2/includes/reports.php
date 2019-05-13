<?php

//Este fichero se encarga de guardar la información recibida por AJAX
//de los reports, en la base de datos

require_once("./config.php");
require_once('./Aplicacion.php');
require_once('./Comentarios.php');


$error = '';
$html = '';

$hoy = date("Y-m-d H:i:s");


/*------------OBTENEMOS INFORMACION DE LA PETICIÓN AJAX---------------*/
$usr_that_report = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
$usr_reported = isset($_POST['usr_reported']) ? $_POST['usr_reported'] : null;
$accion = isset($_POST['accion']) ? $_POST['accion'] : null;
$id_meme = isset($_POST['id_meme']) ? $_POST['id_meme'] : null;


$app = Aplicacion::getInstance();
$conn = $app->conexionBD();

$consultaID = sprintf("SELECT U.id
                FROM users U
                WHERE U.username = '%s'",
            $conn->real_escape_string($usr_that_report)
);

$id_autor = $conn->query($consultaID);
$id_autor = $id_autor->fetch_assoc()['id'];//ID del usuario de la sesion

$consultaID = sprintf("SELECT U.id
                FROM users U
                WHERE U.username = '%s'",
            $conn->real_escape_string($usr_reported)
);

$id_autor_comment = $conn->query($consultaID);
$id_autor_comment = $id_autor_comment->fetch_assoc()['id'];//ID del usuario que subio el meme
/*--------------------------------------------------------------------*/

//Comenzamos a insertar los datos en la BBDD
$query=sprintf("INSERT INTO reports(usr_that_reports, usr_reported)
                VALUES('%s', '%s')",
                $conn->real_escape_string($id_autor),
                $conn->real_escape_string($id_autor_comment)
);

if ( $conn->query($query) ){

    $id_report = $conn->insert_id;
    $causa = $_POST['cause'];

    if($accion === "meme"){

        $query2=sprintf("INSERT INTO me_reports(id_report, cause, id_meme)
                        VALUES ('%s', '%s', '%s')",
            $conn->real_escape_string($id_report),
            $conn->real_escape_string($_POST['cause']),
            $conn->real_escape_string($id_meme));
    }
    else if($accion === "usuario"){
    
        $query2=sprintf("INSERT INTO usr_reports(id_report, cause)
                        VALUES ('%s', '%s')",
            $conn->real_escape_string($id_report),
            $conn->real_escape_string($causa)
        );
    }

    if(! $conn->query($query2)){
        $error = "Ha habido un error al guardar la informacion del report.";
    }
} 
else {
    $error = "Ha habido un error al guardar la informacion del report.";
}
    


//Codificamos la información
$data = array(
    'error' => $error,
    'html' => $html
);

//La enviamos en forma de JSON al cliente
echo json_encode($data);