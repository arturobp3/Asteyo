<?php

require_once('aplicacion.php');

class Meme {

    private $id;
    private $titulo;
    private $num_megustas;
    private $id_autor;
    //fecha y hora de subida
    private $datetime;
    //formato de la imagen
    private $formato;

    
    private function __construct($titulo, $num_megustas, $id_autor, $datetim, $formato){
        $this->titulo= $titulo;
        $this->num_megustas = $num_megustas;
        $this->id_autor = $id_autor;
        $this->datetime = $datetime;
        $this->formato = $formato;
    }

    public function id(){ 
        return $this->id; 
    }

    public function num_megustas(){ 
        return $this->num_megustas;
     }

    public function fechaSubida(){
        return $this->datetime;
    }

    /* Crea un nuevo meme con los datos introducidos por parámetro. */
    public static function crea($titulo, $num_megustas, $id_autor, $datetime, $formato){

        $meme = new Meme($titulo, $num_megustas, $id_autor, $datetime, $formato);

        return self::guarda($meme);
    }

    private static function guarda($meme){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query=sprintf("INSERT INTO memes(title, num_megustas, id_autor, upload_date, formato)
                        VALUES('%s', '%s', '%s', '%s', '%s')",
                            $conn->real_escape_string($meme->titulo),
                            $conn->real_escape_string($meme->num_megustas),
                            $conn->real_escape_string($meme->id_autor),
                            $conn->real_escape_string($meme->datetime),
                            $conn->real_escape_string($meme->formato));
        if ( $conn->query($query) ){
            $meme->id = $conn->insert_id;

        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $meme;
    }


    //Elimina un meme de la base de datos (Funcion creada para el administrador)
    public static function eliminar($meme){
        
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();


        //Borramos el meme asociado a la tablas memes
        $query=sprintf("DELETE FROM memes WHERE id_meme=$meme->id");

        if (! $conn->query($query) ){
            echo "Error al borrar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
            return false;
        } 
        
        unset($meme);

        return true;
    }
    
    //Esta funcion debe actualizar el numero de likes del meme (entre otras cosas??)
    public static function actualiza($meme){
        
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query=sprintf("UPDATE memes M SET num_megustas = num_megustas + 1 WHERE M.id_meme=%i"
            , $meme->id);

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el meme: " . $meme->id;
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $meme;
    }
}
