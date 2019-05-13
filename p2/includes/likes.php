<?php
require_once('config.php');
require_once('Aplicacion.php');
require_once('usuario.php');
require_once('meme.php');
require_once('Like.php');


if($_POST['accion'] === "add"){
	$uName = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
	$mId = isset($_POST['idMeme']) ? $_POST['idMeme'] : null;

	/* validation of the data recieved */
	$usuario = Usuario::buscaUsuario($uName);
	$meme = Meme::getMeme($mId);
	$uId = $usuario->id();

	/* insert the like */
	if ($usuario && $meme) {
		$like = new Like($uId, $mId);
		$success = Like::addLike($like);
		$meme = Meme::actualizaLikes($meme, $_POST['accion']);
		if ($success) {
			echo json_encode(array('success' => true));
		}
		else {
			echo json_encode(array('success' => false));
		}
	}
	else {
		echo json_encode(array('success' => false));
	}
}
else if ($_POST['accion'] === "remove") {
	$uName = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
	$mId = isset($_POST['idMeme']) ? $_POST['idMeme'] : null;

	/* validation of the data recieved */
	$usuario = Usuario::buscaUsuario($uName);
	$meme = Meme::getMeme($mId);
	$uId = $usuario->id();

	/* insert the like */
	if ($usuario && $meme) {
		$like = new Like($uId, $mId);
		$success = Like::removeLike($like);
		$meme = Meme::actualizaLikes($meme, $_POST['accion']);
		if ($success) {
			echo json_encode(array('success' => true));
		}
		else {
			echo json_encode(array('success' => false));
		}
	}
	else {
		echo json_encode(array('success' => false));
	}
	
}
else if ($_POST['accion'] === "search") {
	$uName = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
	$mId = isset($_POST['idMeme']) ? $_POST['idMeme'] : null;

	/* validation of the data recieved */
	$usuario = Usuario::buscaUsuario($uName);
	$meme = Meme::getMeme($mId);
	$uId = $usuario->id();

	/* insert the like */
	if ($usuario && $meme) {
		$like = new Like($uId, $mId);
		$success = Like::searchLike($like);
		if ($success) {
			echo json_encode(array('success' => true));
		}
		else {
			echo json_encode(array('success' => false));
		}
	}
	else {
		echo json_encode(array('success' => false));
	}
}