<?php
require_once('Aplicacion.php');

class Like{
	
	private $idUser;
	private $idMeme;

	public function __construct($idUser, $idMeme){
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
		$result = $conn->query($query); 
		if ($result) {
			if ($conn->affected_rows == 1) {
				return true;
			}
			else{
				return false;
			}
		}
		else {
			return false;
		}
	}

	/* add a like to a meme */
	public static function addLike($like){
		$achievement = "nummg";
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("INSERT INTO megustas(id_user, id_meme) VALUES ('%s', '%s')"
				, $conn->real_escape_string($like->idUser)
				, $conn->real_escape_string($like->idMeme));
		$result = $conn->query($query); 

		$sql = sprintf("SELECT id_autor
						FROM memes 
						WHERE id_meme = '%d'"
						, $conn->real_escape_string($like->idMeme));
		$au = $conn->query($sql);
		$autor = $au->fetch_assoc();

		$sentencia = sprintf("SELECT SUM(num_megustas) as TOTAL 
								FROM memes 
								GROUP BY '%d'"
						, $conn->real_escape_string($autor['id_autor']));
		$sumatotal = $conn->query($sentencia);
		$suma = $sumatotal->fetch_assoc();

		if($suma == 2){
			$logro = sprintf("INSERT INTO achievement(id_user, name, date_got) VALUES ('%s','%s', getdate())"
					, $conn->real_escape_string($autor)
					, $conn->real_escape_string($achievement));
			$inse = $conn->query($logro);
		}

		if ($result) {
			if ($conn->affected_rows == 1) {
				return true;
			}
			else{
				return false;
			}
		}
		else {
			return false;
		}
	}

	/* remove the like given to a meme */
	public static function removeLike($like){
		$app = Aplicacion::getInstance();
		$conn = $app->conexionBD();

		$query = sprintf("DELETE FROM megustas WHERE id_user='%s' AND id_meme = '%s'"
				, $conn->real_escape_string($like->idUser)
				, $conn->real_escape_string($like->idMeme));
		$result = $conn->query($query); 
		if ($result) {
			if ($conn->affected_rows == 1) {
				return true;
			}
			else{
				return false;
			}
		}
		else {
			return false;
		}
	}
}