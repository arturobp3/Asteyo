<?php

require_once('Aplicacion.php');

class Logros{

	private $name;


    private function __construct($name){
        $this->name= $name;
    }

    public function name(){ 
        return $this->name; 
    }

    public static function logroSubir($autor){
    	$app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $name = "submemes";

        $query = sprintf("SELECT id_autor, count(id_meme) as total 
                             FROM memes 
                             WHERE id_autor='%d'
                             GROUP BY id_autor 
                             "
                , $conn->real_escape_string($autor));
        $result = $conn->query($query);

        while($rs = $result->fetch_assoc()){

            if($rs['total'] === 2){ 
                $query = sprintf("INSERT INTO achievement('id_user', 'name', 'date_got')
                                     VALUES('%d', '%s', getdate())"
                                , $conn->real_escape_string($autor)
                                , $conn->real_escape_string($name)); 
                      
                $result = $conn->query($query);
            }
        }
    }
}