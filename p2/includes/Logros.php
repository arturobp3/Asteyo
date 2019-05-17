<?php

namespace es\ucm\fdi\aw;

class Logros{

    public static function logroSubir($datetime, $id_autor){
        //Conexión con la base de datos
        $conn = Aplicacion::getSingleton()->conexionBD();

        $achievement = "submemes";
        /*Hace la suma de todos los likes del autor*/
        $sentencia = sprintf("SELECT id_autor, COUNT(id_meme) AS total 
                                FROM memes 
                                WHERE id_autor = '%d'
                                GROUP BY id_autor"
                            , $conn->real_escape_string($id_autor));
        $sumatotal = $conn->query($sentencia);
        $suma = $sumatotal->fetch_assoc();

        if($suma['total'] == 2){
            $logro = sprintf("INSERT INTO achievement(id_user, name, date_got) VALUES ('%s','%s','%s')"
                    , $conn->real_escape_string($id_autor)
                    , $conn->real_escape_string($achievement)
                    , $conn->real_escape_string($datetime));
            $inse = $conn->query($logro);
        }

         if ($suma) {
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
    } //Fin función logroSubir


    public static function logroComentar($datetime, $id_autor){
        //Cinexión con la base de datos
        $conn = Aplicacion::getSingleton()->conexionBD();

        $achievement = "comentavario";

         /*Hace la suma de todos los likes del autor*/
        $sentencia = sprintf("SELECT id_autor, COUNT(id_comment) AS total 
                                FROM comments 
                                WHERE id_autor = '%d'
                                GROUP BY id_autor"
                        , $conn->real_escape_string($id_autor));
        $sumatotal = $conn->query($sentencia);
        $suma = $sumatotal->fetch_assoc();

        if($suma['total'] == 2){
            $logro = sprintf("INSERT INTO achievement(id_user, name, date_got) VALUES ('%s','%s','%s')"
                        , $conn->real_escape_string($id_autor)
                        , $conn->real_escape_string($achievement)
                        , $conn->real_escape_string($datetime));
            $inse = $conn->query($logro);
        }  

        if ($suma) {
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

    } //Fin funcion logroComentar



    public static function logroMeGusta($datetime, $id_meme){

       $conn = Aplicacion::getSingleton()->conexionBD();

        $achievement = "nummg";

        /*Coge el id del autor del creador del meme*/
        $sql = sprintf("SELECT id_autor
                        FROM memes 
                        WHERE id_meme = '%d'"
                    , $conn->real_escape_string($id_meme));
        $au = $conn->query($sql);
        $autor = $au->fetch_assoc();

        /*Hace la suma de todos los likes del autor*/
        $sentencia = sprintf("SELECT id_autor, SUM(num_megustas) AS total 
                                FROM memes 
                                WHERE id_autor = '%d'
                                GROUP BY id_autor"
                        , $conn->real_escape_string($autor['id_autor']));
        $sumatotal = $conn->query($sentencia);
        $suma = $sumatotal->fetch_assoc();

        if($suma['total'] == 2){
            $logro = sprintf("INSERT INTO achievement(id_user, name, date_got) VALUES ('%s','%s','%s')"
                , $conn->real_escape_string($autor['id_autor'])
                , $conn->real_escape_string($achievement)
                , $conn->real_escape_string($datetime));
            $inse = $conn->query($logro);
        } 

        if ($suma) {
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

    public static function comprobarLogros($nombre){
        //Obtenemos el usuario actual
        $username = $_SESSION['nombre'];

        //Buscamos sus datos en la bbdd
        $usuario = Usuario::buscaUsuario($username);

        $conn = Aplicacion::getSingleton()->conexionBD();
        //Coge si existe el usuario en la tabla de logros con el nombre del meme
        $query = sprintf("SELECT * 
                            FROM achievement
                            WHERE name = '%s'
                            AND id_user = '%d'"
                        , $conn->real_escape_string($nombre)
                        , $conn->real_escape_string($usuario->id()));
        $resultado = $conn->query($query);

        return $resultado;

    }
   
}
