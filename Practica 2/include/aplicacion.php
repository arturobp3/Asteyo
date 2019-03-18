<?php


/**
 * Clase que mantiene el estado de la aplicacion utilizando el patron Singleton
 */
class Aplicacion{

    //Instancia Singleton
    private static $instance;

    // Booleano para saber si la aplicación ha sido inicializada
    private $ini;

    // Array con los datos necesarios para conectarse a la BBDD
    private $bdConexion;

    //Conexion con la BD
    private $conn;


    public static function getInstance(){

        if(! isset(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function init($datosBD){
        if(! $this->ini){

            $this->bdConexion = $datosBD;
            $this->ini = true;
        }
    }

    public function conexionBD(){
        //Si la aplicacion se ha inicializado
        if($this->ini){

            //Si NO se ha creado una conexión con la BD
            if(! $this->conn){
                $host = $this->bdConexion['host'];
                $user = $this->bdConexion['user'];
                $pass = $this->bdConexion['pass'];
                $bd = $this->bdConexion['bd'];

                //Realiza la conexion
                $this->conn = new \mysqli($host, $user, $pass, $bd);
                if ( $this->conn->connect_errno ) {
                    echo "Error de conexión a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
                    exit();
                }
                if ( ! $this->conn->set_charset("utf8mb4")) {
                    echo "Error al configurar la codificación de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
                    exit();
                }
            }

            return $this->conn; 
        }
        else{
            echo "Aplicacion no inicializada";
            exit();
        }
	    
    }
    
    public function shutdown(){

         //Si la aplicacion se ha inicializado
        if($this->ini){
            //Si se ha realizado una conexion
            if ($this->conn !== null) {
                $this->conn->close();
            }
        }
         else{
            echo "Aplicacion no inicializada";
            exit();
        }
	}
}