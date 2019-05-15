<?php

require_once('Aplicacion.php');

class Usuario {

    private $id;
    private $username;
    private $email;
    private $password;
    private $rol;


    private function __construct($username, $email, $password, $rol){
        $this->username= $username;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
    }

    public function id(){ 
        return $this->id; 
    }

    public function rol(){ 
        return $this->rol;
     }

    public function username(){
        return $this->username;
    }

    public function setUserName($username){

        $this->username = $username;
    }

    public function cambiaPassword($nuevoPassword){
        $this->password = password_hash($nuevoPassword, PASSWORD_DEFAULT);
    }


    /* Devuelve un objeto Usuario con la información del usuario $username,
     o false si no lo encuentra*/
    public static function buscaUsuario($username){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT * FROM users U WHERE U.username = BINARY '%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['username'], $fila['email'], $fila['password'], $fila['rol']);
                $user->id = $fila['id'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    /*Comprueba si la contraseña introducida coincide con la del Usuario.*/
    public function compruebaPassword($password){
        return password_verify($password, $this->password);
    }

    /* Devuelve un objeto Usuario si el usuario existe y coincide su contraseña. En caso contrario,
     devuelve false.*/
    public static function login($username, $password){
        $user = self::buscaUsuario($username);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }
    
    /* Crea un nuevo usuario con los datos introducidos por parámetro. */
    public static function crea($username, $email, $password, $rol){
        $user = self::buscaUsuario($username);
        if ($user) {
            return false;
        }
        $user = new Usuario($username, $email, password_hash($password, PASSWORD_DEFAULT), $rol);
        return self::guarda($user);
    }
    
    
    public static function guarda($usuario){
        if ($usuario->id !== null) {
            return self::update($usuario);
        }
        return self::inserta($usuario);
    }
    
    private static function inserta($usuario){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("INSERT INTO users(username, email, password, rol) VALUES('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol));

        if ( $conn->query($query) ){
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
    
    public static function update($usuario){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("UPDATE users U SET U.username = '%s', U.email='%s', U.password='%s', U.rol='%s' WHERE U.id=%d"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $conn->real_escape_string($usuario->id));
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $usuario;
    }

    public static function cambiarRol($rol, $username){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("UPDATE users U SET U.rol='%s' WHERE U.username=%d"
            , $conn->real_escape_string($rol)
            , $conn->real_escape_string($username));

        

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        } else {
            echo "Error al actualizar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
    }

    public static function memes($username){
        $usuario = self::buscaUsuario($username);
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("SELECT * FROM memes WHERE id_autor= '%s' ORDER BY id_meme DESC", $conn->real_escape_string($usuario->id()));
        $rs = $conn->query($query);
        $rt=false;
      
        if ($rs){
            if($rs->num_rows>0){
                /*array de memes*/
                $rt=array();
                $i = 0;
                while($row = mysqli_fetch_assoc($rs)){
                    /*array de cada meme*/
                    $rj=array();
                    $rj[0] = $row['title']; $rj[1] = $row['num_megustas']; $rj[2] = $row['id_meme']; 
                    $rt[$i] = $rj;
                    $i = $i + 1;
                }
            }
            $rs->free();
        }
        else{
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit(); 
        }
        return $rt;
    }

    public static function top10(){
        $users = self::numUsers();
        for($i=0; $i< $users; $i++){
            $mg=self::numMegustas($i+1);
            $user=self::buscaId($i+1);
            $rt[]=array(
                'mg' => $mg,
                'user' => $user
            );
        }

        arsort($rt);
        $rt=array_slice($rt,0,5);
        
        return $rt;
        
    }

    public static function buscaId($id){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT username FROM users U WHERE U.id = '%s'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $result= $fila['username'];
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function numMegustas($id){
        $app =Aplicacion::getInstance();
        $conn= $app->conexionBD();
        $query = sprintf("SELECT num_megustas FROM memes WHERE id_autor=".$id);
        $rs = $conn->query($query);

        if($rs){
            $mg=0;
            for ($i = 0; $i< $rs->num_rows; $i++){
                $fila = $rs->fetch_assoc();
                $mg+=$fila['num_megustas'];
            }
        }
        else{
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $mg;
    }
    

    public static function numUsers(){
        $app =Aplicacion::getInstance();
        $conn= $app->conexionBD();
        $query = sprintf("SELECT id FROM users");
        $rs = $conn->query($query);
        if (!$rs){
            echo "Error al consultar en la BD: (". $conn->errno . ")".utf8_encode($conn->error);
        }
        return $rs->num_rows;
    }

    public static function formatoRanking($infoUser, $i = NULL){
        $usuario = self::buscaUsuario($infoUser['user']);
        $span = "<span>\u{1F3C5}</span>";
  
        if($i==1) 		$span = "<span>\u{1F947}</span>";
		else if($i==2)	$span = "<span>\u{1F948}</span>";
		else if($i==3)	$span = "<span>\u{1F949}</span>";
						
        
        return 
        "<div id='info'>
            ".$span."
                <div id='img'>
                    <img id='user-profile-picture' src='./uploads/".$usuario->id()."/fotoPerfil.jpg'/>
                </div>
                <div id='meme-info'>
                   <p><a href='perfil.php?userName=".$usuario->username()."'>".$usuario->username()."</a></p>
                   <p>".$infoUser['mg']."<p>
               </div>
        </div>";
    }


    
    
}
