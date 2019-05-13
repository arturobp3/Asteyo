<?php

//Inicio del procesamiento
require_once("includes/config.php");
require_once("includes/Meme.php");
require_once("includes/usuario.php");
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/general.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/index.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/meme.css" />
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
				$i = 0;
				foreach ($result as $part) {
					echo "<div id='info'>";
						if($i==0) echo "<span>\u{1F947}</span>";
						else if($i==1)echo "<span>\u{1F948}</span>";
						else if($i==2)echo "<span>\u{1F949}</span>";
						else echo "<span>\u{1F3C5}</span>";
						
						if($esUser){
							echo Usuario::formatoRanking($part, $i)."</div>";
							
						} 
					
						else echo "</div>".Meme::formatoMeme($part);

						$i++;
					;
				}
			}
        ?>	
		</div>

	</div>

	<?php require("includes/comun/pie.php"); ?>

</div>

</body>
</html>