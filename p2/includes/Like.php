<?php
require_once('Aplicacion.php');

class Like{
	
	private $idUser;
	private $idMeme;

	private function __construct($idUser, $idMeme){
		$this->idUser = $idUser;
		$this->idMeme = $idMeme;
	}

	public function idUser(){
		return $this->idUser;
	}

	public function idMeme(){
		return $this->idMeme;
	}

	/* look if the pair user-meme is already in the liked table */
	public static function searchLike($like){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("SELECT * FROM megustas WHERE id_user='%d' AND id_meme = '%d'"
				, $conn->real_escape_string($like->idUser)
				, $conn->real_escape_string($like->idMeme));
		if ($conn->query($query)) {
			return true;
		}
		else {
			return false;
		}
	}

	/* add a like to a meme */
	public static function addLike($like){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("INSERT INTO megustas(id_user, id_meme) VALUES ('%d', '%d')"
				, $conn->real_escape_string($like->idUser)
				, $conn->real_escape_string($like->idMeme));
		if ($conn->query($query)) {
			return true;
		}
		else {
			return false;
		}
	}

	/* remove the like given to a meme */
	public static function removeLike($like){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("DELETE FROM megustas WHERE id_user='%d' AND id_meme = '%d')"
				, $conn->real_escape_string($like->idUser)
				, $conn->real_escape_string($like->idMeme));
		if ($conn->query($query)) {
			return true;
		}
		else {
			return false;
		}
	}
}