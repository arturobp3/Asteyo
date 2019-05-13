<?php

require_once('Aplicacion.php');
require_once('hashtag.php');

class Meme {

    private $id;
    private $titulo;
    private $num_megustas;
    private $id_autor;
    //fecha y hora de subida
    private $datetime;
    private $comentarios;

    

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

    public function comentarios(){
        return $this->comentarios;
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
    
    /* Esta funcion debe actualizar el numero de likes del meme en las tablas de meme y hashtag */
    public static function actualizaLikes($meme, $accion){
        
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        if ($accion === "add") {
        	$query=sprintf("UPDATE memes M SET M.num_megustas = M.num_megustas + 1 WHERE M.id_meme='%d'"
            , $conn->real_escape_string($meme->id));
        }
        else if ($accion === "remove") {
        	$query=sprintf("UPDATE memes M SET M.num_megustas = M.num_megustas - 1 WHERE M.id_meme='%d'"
            , $conn->real_escape_string($meme->id));
        }

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el meme pinche: " . $meme->id;
                exit();
            }
            else{

            	/* seleccionamos los hashtag que el meme tiene */
            	$query2=sprintf("SELECT name_hash FROM hashtag_meme H JOIN memes M WHERE H.id_meme = M.id_meme AND M.id_meme='%d'"
		            , $conn->real_escape_string($meme->id));

            	$rs = $conn->query($query2);
			    if ($rs) {
			        if ( $conn->affected_rows == 0) {
			            echo "No se ha podido actualizar el meme de la reconcha: " . $meme->id;
			            exit();
			        }
                    else{
                        for ($i=0; $i < $rs->num_rows; $i++) { 
                            $hashtagName = $rs->fetch_assoc();
                            /* realizamos la accion correspondiente a cada numero de likes de un hastag por vuelta del bucle*/
                            $hashtag = Hashtag::update($hashtagName['name_hash'], $accion);
                        }
                    }
			    } else {
    			    echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
    			    exit();
			    }
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
                        WHERE M.id_meme=$id");

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
                $meme->comentarios = array();

                
                $query = sprintf("SELECT * 
                                FROM memes M JOIN users U JOIN comments C
                                WHERE M.id_meme=$id
                                AND C.id_autor = U.id
                                AND M.id_meme = C.id_meme");

                $rs2 = $conn->query($query);

                if($rs2){
                    if ( $rs2->num_rows > 0) {

                        $m;
                        for($i = 0; $i < $rs2->num_rows; $i++){
                            $fila = $rs2->fetch_assoc();
        
                            $m[] = array(
                                'texto' => $fila['texto'],
                                'fecha' => $fila['c_date'],
                                'autor' => $fila['username'],
                                'id_comment' => $fila['id_comment']
                            );
                        }

                        $meme->comentarios = $m;

                        $rs2->free();
                    }
                }

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
                        'nameMeme' => $fila['title'],
                        'numLikes' => $fila['num_megustas']
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
                        'nameMeme' => $fila['title'],
                        'numLikes' => $fila['num_megustas']
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
                        'name' => $fila['name'],
                        'n_mg' => $fila['n_mg']
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

   public static function top10(){
       $app = Aplicacion::getInstance();
       $conn = $app->conexionBD();

       $query = sprintf("SELECT *
                        FROM users U JOIN memes M
                       WHERE U.id = M.id_autor
                        ORDER BY num_megustas DESC");


        $rs = $conn->query($query);
        
        if ($rs) {

            if ( $rs->num_rows > 0) {
                $publications = $rs->num_rows > 10 ? 10 : $rs->num_rows;
 
                 for($i = 0; $i < $publications; $i++){
                     $fila = $rs->fetch_assoc();

                     

                     $memes[] = array(
                         'username' => $fila['username'],
                         'id' => $fila['id_meme'],
                         'nameMeme' => $fila['title'],
                         'numLikes' => $fila['num_megustas']
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

   public static function formatoMeme($meme, $i=NULL){
        $usuario = Usuario::buscaUsuario($meme['username']);


        if($i){
            $span = "<span class='span-ranking'>\u{1F3C5}</span>";
            if($i==1) 		$span = "<span class='span-ranking'>\u{1F947}</span>";
		    else if($i==2)	$span = "<span class='span-ranking'>\u{1F948}</span>";
		    else if($i==3)	$span = "<span class='span-ranking'>\u{1F949}</span>";
        }
        else $span = "";

        

        return
        '<a class="memes" href="./Meme.php?userName='.$meme['username'].'&id='.$meme['id'].'">
            <div id="meme">
                <div id="meme-title">
                    <p>'.$span." ".$meme['nameMeme'].'</p>
                </div>
                <div id="meme-container">
                    <img id="img-meme" src="uploads/'.$usuario->id().'/'.$meme['id'].'.jpg"/>
                </div>
                <div id="meme-info">
                    <div id="user-info">
                        <img id="user-profile-picture" src="./uploads/'.$usuario->id().'/fotoPerfil.jpg"/>
                        <p> by '.$meme['username'].'</p>
                    </div>
                    <p>'.$meme['numLikes'].' me gusta</p>
                </div>
            </div>
        </a>';
   }
}

