<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/meme.php");

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/estilo.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Meme | Asteyo</title>
</head>

<body>

<div class="contenedor">

	<?php require("includes/comun/cabecera.php"); ?>

	<div class="principal">
		<?php require("includes/comun/sidebarIzq.php");?>

		<div id="contenido">
		<?php

            if(isset($_GET['name']) && isset($_GET['id'])){

                $usuario = $_GET['name'];
                $id_meme = $_GET['id'];
                $url = 'uploads/'.$usuario.'/'.$id_meme.'.jpg';

                if (file_exists($url)) {
                    //Obtiene la información relevante del meme para mostrarla.
                    $info_meme = Meme::getMeme($id_meme);

                    echo " <p> Titulo: ".$info_meme->titulo()."</p>
                            <p> Usuario: ".$usuario."</p>
                            <img id='img-meme' src='".$url."'/>
                            <p>Me gustas: ".$info_meme->num_megustas()."</p>
                            <p>Fecha de subida: ".$info_meme->fechaSubida()."</p>
                            
                            <p>COMENTARIOS</p>";


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