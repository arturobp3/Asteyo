<?php

require_once('aplicacion.php');

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

    public function cambiaPassword($nuevoPassword){
        $this->password = self::hashPassword($nuevoPassword);
    }


    /* Devuelve un objeto Usuario con la información del usuario $username,
     o false si no lo encuentra*/
    public static function buscaUsuario($username){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();

        $query = sprintf("SELECT * FROM users U WHERE U.username = '%s'", $conn->real_escape_string($username));
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
            return self::actualiza($usuario);
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
    
    private static function actualiza($usuario){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("UPDATE users U SET username = '%s', email='%s', password='%s', rol='%s' WHERE U.id=%i"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->id);
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

    public static function memes($username){
        $usuario = self::buscaUsuario($username);
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        $query=sprintf("SELECT * FROM memes WHERE id_autor= '%s'", $conn->real_escape_string($usuario->id()));
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
                    $rj[0] = $row['title']; $rj[1] = $row['num_megustas']; $rj[2] = $row['link_img']; 
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
    
}
