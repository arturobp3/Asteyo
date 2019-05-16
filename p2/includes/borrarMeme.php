<?php
	
	require_once('config.php');
	require_once('Aplicacion.php');

	$app = Aplicacion::getInstance();
	$conn = $app->conexionBD();
	
	
	
	

	$query = sprintf("SELECT U.id_report, X.id_autor
                FROM me_reports U 
				JOIN memes X ON U.id_meme=X.id_meme
				WHERE U.id_meme='%d'",
				$_GET['id_meme']);
				
	if($resultado = $conn->query($query)){
		$fila = $resultado->fetch_assoc();
		$delete = sprintf("DELETE FROM reports WHERE id_report='%d'",
				$fila['id_report']);
		if($resultado = $conn->query($delete)){
			$delete = sprintf("DELETE FROM memes WHERE id_meme='%d'",
				$_GET['id_meme']);
			$conn->query($delete);
			
			unlink('../uploads/'.$fila['id_autor'].'/'.$_GET['id_meme']);
			
			header('Location: ../moderador.php'); //Siguiente pagina
            exit();
		}else{
			echo "no se pudo realizar la consulta a la base de datos";
		}
	}else{
		echo "no se pudo realizar la consulta a la base de datos";
	}

		