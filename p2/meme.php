<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/meme.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/estilo-general.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/estilo-meme.css" />
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Meme | Asteyo</title>
</head>

<body>

<div class="contenedor">

	<?php require("includes/comun/cabecera.php"); ?>

	<div class="principal">
		<?php require("includes/comun/sidebarIzq.php");?>

		<div class="contenido-meme">
		<?php

            if(isset($_GET['name']) && isset($_GET['id'])){

                $usuario = $_GET['name'];
                $id_meme = $_GET['id'];
                $url = 'uploads/'.$usuario.'/'.$id_meme.'.jpg';

                if (file_exists($url)) {
                    //Obtiene la información relevante del meme para mostrarla.
                    $info_meme = Meme::getMeme($id_meme);
                    $title = $info_meme->titulo();
                    $num_likes = $info_meme->num_megustas();
                    $date = $info_meme->fechaSubida();
                    
                    echo '<img id="img-meme" src="'.$url.'"/>
                    <div id="info">
                        <img id="user-profile-picture" src="./uploads/'.$usuario.'/fotoPerfil.jpg"/>
                        <div id="meme-info">
                            <p id="title">'.$title.'</p>
                            <p> by '.$usuario.'</p>
                        </div>
                    </div>
                    <div id="meme-data">
                        <p>'.$num_likes.' me gustas</p>
                        <p>Fecha de subida: '.$date.'</p>
                    </div>
                    <h3>COMENTARIOS</h3>
                    <div id="comment-section">
                    </div>';
                } 
                else {
                    echo "<h1 class='mensaje'> ¡No se ha encontrado el meme! </h1>";
                }
            }
            else{
                echo "<h1 class='mensaje'> ¡No se ha encontrado el meme! </h1>";
            }


	
		
        ?>	
		</div>

	</div>

	<?php require("includes/comun/pie.php"); ?>

</div>

</body>
</html>