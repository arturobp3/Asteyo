<?php


class Comentarios{

    private $id;
    private $id_autor;
    private $id_meme;
    private $texto;
    private $c_date;


    public function __construct($id_autor, $id_meme, $texto, $c_date){
        $this->id_autor = $id_autor;
        $this->id_meme = $id_meme;
        $this->texto = $texto;
        $this->c_date = $c_date;
    }


    public function addComment(){

        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        
        $query=sprintf("INSERT INTO comments(id_autor, id_meme, texto, c_date)
                        VALUES('%s', '%s', '%s', '%s')",
                            $conn->real_escape_string($this->id_autor),
                            $conn->real_escape_string($this->id_meme),
                            $conn->real_escape_string($this->texto),
                            $conn->real_escape_string($this->c_date)
        );

        if ( $conn->query($query) ){
            $html = "<div id='cajaComentario'>
                <p id='user'>".$_SESSION['nombre']."</p>
                <p id='fecha'>".$this->c_date."</p>
                <p id='comentario'>".$this->texto."</p>";

            if(isset($_SESSION['login']) && $_SESSION['esModerador']){
                $html .= " 
                <div class='botones'>
                    <a onclick='borrarComentario($conn->insert_id)'>
                        Eliminar
                    </a>
                </div>";
            }
            //Si es usuario puede reportarlo
            else if(isset($_SESSION['login']) && $_SESSION['esUser']){
                $html .= "
                <div class='botones'>
                    <a onclick='reportarComentario($conn->insert_id)'>
                        Reportar
                    </a>
                </div>";
            }

            $html .= "</div>";

            return $html;
        } 
        else {
            return false;
        }
    }


}