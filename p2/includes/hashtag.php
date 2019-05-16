<?php
require_once('Aplicacion.php');

class Hashtag {

    private $name;
    private $id_meme;
    private $n_mg;
    private $n_memes;
    
    private function __construct($name, $id_meme, $n_mg = 0, $n_memes = 0){
        $this->name = $name;
        $this->id_meme = $id_meme;
        $this->n_mg = $n_mg;
        $this->n_memes = $n_memes;
    }

    public function id_meme(){ 
        return $this->id_meme; 
    }

    public function name(){
        return $this->name;
    }

    public function n_mg(){
        return $this->n_mg;
    }

    public function n_memes(){
        return $this->n_memes;
    }

    /* Crea un nuevo meme con los datos introducidos por parámetro. */
    public static function create($name, $id_meme){

        $hashtag = new Hashtag($name, $id_meme);
        return self::save($hashtag);
    }

    public static function searchHashtag($hashtag){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();


        $query = sprintf("SELECT * FROM hashtags U WHERE U.name = '%s'", $conn->real_escape_string($hashtag->name()));

        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows > 0) {
                $fila = $rs->fetch_assoc();
                $result = new Hashtag($fila['name'], $hashtag->id_meme, $fila['n_mg'], $fila['n_memes']);
                $result = $hashtag;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }


    private static function createRelation($hashtag){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query=sprintf("INSERT INTO hashtag_meme(name_hash, id_meme)
                            VALUES('%s', '%s')",
                                $conn->real_escape_string($hashtag->name),
                                $conn->real_escape_string($hashtag->id_meme));
        if ( !$conn->query($query) ){
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $hashtag;
    }

    private static function insert($hashtag){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query=sprintf("INSERT INTO hashtags(name, n_memes, n_mg) VALUES('%s', '%d', '%d')"
            , $conn->real_escape_string($hashtag->name)
            , $conn->real_escape_string($hashtag->n_memes)
            , $conn->real_escape_string($hashtag->n_mg));

        if ( !$conn->query($query) ){
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $hashtag;
    }

    private static function save($hashtag){
        
        $existe = self::searchHashtag($hashtag);

        if (!$existe){
            
           self::insert($hashtag);
        }
        self::createRelation($hashtag);
        $hashtag = self::update($hashtag, "add");
        return $hashtag;
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

    /* Esta funcion debe actualizar el numero de memes asociados a un hashtag */
    public static function update($hashtag){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $hashtag->n_memes+=1;

        $query=sprintf("UPDATE hashtags H SET H.n_memes = H.n_memes + 1 WHERE H.name='%s'"
                , $conn->real_escape_string($hashtag->name));

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el meme: " . $hashtag->id_meme;
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $hashtag;
    }
    
    //Esta funcion debe actualizar el numero de likes asociados a un hashtag
    public static function updateLikes($hashtag, $accion){
        
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        if ($accion === "add") {
            $query=sprintf("UPDATE hashtags H SET H.n_mg = H.n_mg + 1 WHERE H.name='%s'"
                , $conn->real_escape_string($hashtag));
        }
        else if ($accion === "remove") {
            $query=sprintf("UPDATE hashtags H SET H.n_mg = H.n_mg - 1 WHERE H.name='%s'"
                , $conn->real_escape_string($hashtag));
        }

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el meme de los hashtags: " . $hashtag;
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $hashtag;
    }
}
