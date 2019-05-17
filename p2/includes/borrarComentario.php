<?php
	
	namespace es\ucm\fdi\aw;
	require_once __DIR__.'/config.php';

	$app = Aplicacion::getSingleton();
    $conn = $app->conexionBD();
	
	
	
	

	$query = sprintf("SELECT U.id_report
                FROM co_reports U 
				JOIN comments X ON U.id_comment=X.id_comment
				WHERE U.id_comment='%d'",
				$_GET['id_comment']);
				
	if($resultado = $conn->query($query)){
		$fila = $resultado->fetch_assoc();
		$delete = sprintf("DELETE FROM reports WHERE id_report='%d'",
				$fila['id_report']);
		if($resultado = $conn->query($delete)){
			$delete = sprintf("DELETE FROM comments WHERE id_comment='%d'",
				$_GET['id_comment']);
			$conn->query($delete);
			
			header('Location: ../moderador.php'); //Siguiente pagina
            exit();
		}else{
			echo "no se pudo realizar la consulta a la base de datos";
		}
	}else{
		echo "no se pudo realizar la consulta a la base de datos";
	}

		