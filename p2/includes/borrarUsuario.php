<?php
	
	require_once('config.php');
	require_once('Aplicacion.php');

	$app = Aplicacion::getInstance();
	$conn = $app->conexionBD();
	
	
	
	

	$query = sprintf("SELECT U.id_report, X.id
                FROM reports U 
				JOIN users X ON U.usr_reported=X.id
				WHERE X.username='%s'",
				$conn->real_escape_string($_GET['userName']));
				
	if($resultado = $conn->query($query)){
		$fila = $resultado->fetch_assoc();
		$delete = sprintf("DELETE FROM reports WHERE usr_reported='%d'",
				$fila['id']);
		if($resultado = $conn->query($delete)){
			$delete = sprintf("DELETE FROM users WHERE id='%d'",
				$fila['id']);
			$conn->query($delete);
			
			//unlink('../uploads/'.$fila['id_autor'].'/'.$_GET['id_meme']);
			
			header('Location: ../moderador.php'); //Siguiente pagina
            exit();
		}else{
			echo "no se pudo realizar la consulta a la base de datos";
		}
	}else{
		echo "no se pudo realizar la consulta a la base de datos";
	}

		