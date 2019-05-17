<?php

//Este fichero se encarga de guardar la información recibida por AJAX
//de los reports, en la base de datos

namespace es\ucm\fdi\aw;


function getMemeReports(){
	$conn = Aplicacion::getSingleton()->conexionBD();

	$query = sprintf("SELECT U.id_report, U.cause, U.id_meme, V.usr_reported, W.username
                FROM me_reports U JOIN reports V ON U.id_report=V.id_report
				JOIN users W ON V.usr_reported=W.id");
	
	if($resultado = $conn->query($query)){
		echo '<table class="reports">
				<tr>
				<th>Causa</th>
				<th>ID Meme</th>
				<th>Usuario reportado</th>
				<th>Eliminar</th>
				</tr>';
		while ($fila = $resultado->fetch_assoc()) {
			echo "<tr>
						<td>". $fila['cause'] . "</td>
						<td><a class='memes' href='./Meme.php?userName=".$fila['username']."&id=".$fila['id_meme']."'>".$fila['id_meme']."</a></td>
						<td>". $fila['username']."</td>
						<td><a href='./includes/borrarMeme.php?id_meme=". $fila['id_meme'] ."' >\u{274C}</a></td>
				  </tr>";
			
		}
		echo '</table>';
	}else{
		echo "Ha ocurrido un error durante la consulta";
	}
	
	
}

function getUserReports(){
	$conn = Aplicacion::getSingleton()->conexionBD();

	$query = sprintf("SELECT U.id_report, U.cause, V.usr_reported, W.username
                FROM usr_reports U JOIN reports V ON U.id_report=V.id_report JOIN users W ON V.usr_reported=W.id");
	
	if($resultado = $conn->query($query)){
		echo '<table class="reports">
				<tr>
				<th>Causa</th>
				<th>Usuario reportado</th>
				<th>Eliminar</th>
				
				</tr>';
		while ($fila = $resultado->fetch_assoc()) {
			echo "<tr>
						<td>". $fila['cause'] . "</td>
						<td><a class='memes' href='./perfil.php?userName=".$fila['username']."'>".$fila['username']."</a></td>
						<td><a href='./includes/borrarUsuario.php?userName=". $fila['username'] ."' >\u{274C}</a></td>
				  </tr>";
		}
		echo '</table>';
	}else{
		echo "Ha ocurrido un error durante la consulta";
	}
}

function getCommentReports(){
	$conn = Aplicacion::getSingleton()->conexionBD();

	$query = sprintf("SELECT U.id_report, U.cause, X.texto, W.username, U.id_comment
                FROM co_reports U JOIN reports V ON U.id_report=V.id_report JOIN users W ON V.usr_reported=W.id
				JOIN comments X ON U.id_comment=X.id_comment");
	
	if($resultado = $conn->query($query)){
		echo '<table class="reports">
				<tr>
				<th>Causa</th>
				<th>Comentario</th>
				<th>Usuario reportado</th>
				<th>Eliminar</th>
				</tr>';
		while ($fila = $resultado->fetch_assoc()) {
			echo "<tr class= 'reports'>
						<td>". $fila['cause'] . "</td>
						<td>".$fila['texto']."</td>
						<td>".$fila['username']."</td>
						<td><a href='./includes/borrarComentario.php?id_comment=". $fila['id_comment'] ."' >\u{274C}</a></td>
				  </tr>";
		}
		echo '</table>';
	}else{
		echo "Ha ocurrido un error durante la consulta";
	}
}

