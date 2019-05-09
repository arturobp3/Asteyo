<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/meme.php");
require_once("includes/usuario.php");
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/index.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Inicio | Asteyo</title>
</head>

<body>

<div class="contenedor">

	<?php require("includes/comun/cabecera.php"); ?>

	<div class="principal">
		<?php require("includes/comun/sidebarIzq.php");?>

		<div class="contenido-index">
		<?php
            $esUser= false;
            $result=false;
            if(isset($_GET['tipo'])){
                if($_GET['tipo']==='masMg'){
                    //Ranking más me gustas
                    $result = Meme::top10();
                    
                }
                else if ($_GET['tipo']==='masSeg'){
                    $result = Usuario::top10();
                    
                    $esUser= true;
				}
            }


			if($result === false){
				echo "<h1> ¡No se han encontrado resultados! </h1>";
			}
			else{
				foreach ($result as $part) {
					if($esUser) echo Usuario::formatoRanking($part);
					else echo Meme::formatoRanking($part);
				}
			}
        ?>	
		</div>

	</div>

	<?php require("includes/comun/pie.php"); ?>

</div>

</body>
</html>