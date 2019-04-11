<?php

require_once('aplicacion.php');

class Meme {

    private $id;
    private $titulo;
    private $num_megustas;
    private $id_autor;
    //fecha y hora de subida
    private $datetime;

    

    private function __construct($titulo, $num_megustas, $id_autor, $datetime){
        $this->titulo= $titulo;
        $this->num_megustas = $num_megustas;
        $this->id_autor = $id_autor;
        $this->datetime = $datetime;
    }

    public function id(){ 
        return $this->id; 
    }

    public function titulo(){
        return $this->titulo;
    }

    public function num_megustas(){ 
        return $this->num_megustas;
     }

    public function fechaSubida(){
        return $this->datetime;
    }

    /* Crea un nuevo meme con los datos introducidos por parámetro. */
    public static function crea($titulo, $num_megustas, $id_autor, $datetime){

        $meme = new Meme($titulo, $num_megustas, $id_autor, $datetime);

        return self::guarda($meme);
    }

    private static function guarda($meme){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query=sprintf("INSERT INTO memes(title, num_megustas, id_autor, upload_date)
                        VALUES('%s', '%s', '%s', '%s')",
                            $conn->real_escape_string($meme->titulo),
                            $conn->real_escape_string($meme->num_megustas),
                            $conn->real_escape_string($meme->id_autor),
                            $conn->real_escape_string($meme->datetime));
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

    //Devuelve un meme en base a su id
    public static function getMeme($id){
        
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT * 
                        FROM memes M 
                        WHERE M.id_meme=".$id);

       $rs = $conn->query($query);
       $result = false;

        if ($rs) {
           //Si la consulta devuelve muchos memes

           if ( $rs->num_rows > 0) {

                $fila = $rs->fetch_assoc();

                //Cogemos la información del meme
                $meme = new Meme($fila['title'],  $fila['num_megustas'], $fila['id_autor'],
                    $fila['upload_date']);

                $meme->id = $fila['id_meme'];
                
                $result = $meme;
            }
            $rs->free();
           
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        

        return $result;

    }



    //Devuelve los ultimos memes subidos (DEVUELVE TODOS). Se utiliza en la pantalla principal
    public static function lastMemes(){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT * 
                       FROM users U JOIN memes M
                       WHERE U.id = M.id_autor 
                       ORDER BY upload_date DESC");

       $rs = $conn->query($query);
       $result = false;

        if ($rs) {
           //Si la consulta devuelve muchos memes
           if ( $rs->num_rows > 0) {

                for($i = 0; $i < $rs->num_rows; $i++){
                    $fila = $rs->fetch_assoc();

                    $memes[] = array(
                        'username' => $fila['username'],
                        'id' => $fila['id_meme'],
                        'nameMeme' => $fila['title']
                    );
                }
                    $rs->free();
                    return $memes;
            }
            

           
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        

        return $result;
    }


    //Devuelve los memes que utilicen dicho hashtag (UTILIZADO EN EL BUSCADOR)
    public static function searchMemeHashtag($nombreHashtag){

        $app = Aplicacion::getInstance();
       $conn = $app->conexionBD();

       $query = sprintf("SELECT * 
                       FROM hashtag_meme H JOIN memes M JOIN users U
                       WHERE H.id_meme = M.id_meme 
                            AND U.id = M.id_autor
                            AND H.name_hash = '%s'
                       ORDER BY upload_date DESC", $conn->real_escape_string($nombreHashtag));

       $rs = $conn->query($query);
       $result = false;

       if ($rs) {

           //Si la consulta devuelve muchos memes
           if ( $rs->num_rows > 0) {

                for($i = 0; $i < $rs->num_rows; $i++){
                    $fila = $rs->fetch_assoc();

                    $memes[] = array(
                        'username' => $fila['username'],
                        'id' => $fila['id_meme'],
                        'nameMeme' => $fila['title']
                    );
                }
                $rs->free();
                return $memes;
            }
       } else {
           echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
           exit();
       }
       return $result;
   }


   //Ordena los hashtags por numero de memes, se utiliza en el sidebar
   public static function rankHashtag(){

        $app = Aplicacion::getInstance();
       $conn = $app->conexionBD();

       $query = sprintf("SELECT * 
                       FROM hashtags
                       ORDER BY n_memes DESC LIMIT 10");

       $rs = $conn->query($query);
       $result = false;

       if ($rs) {

           //Si la consulta devuelve muchos hashtags
           if ( $rs->num_rows > 0) {

                for($i = 0; $i < $rs->num_rows; $i++){
                    $fila = $rs->fetch_assoc();

                    $hashtags[] = array(
                        'name' => $fila['name']
                    );
                }
                $rs->free();
                return $hashtags;
            }
       } else {
           echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
           exit();
       }
       return $result;
   }
}

