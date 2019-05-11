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
            $html = "<div class='cajaComentario' id='$conn->insert_id'>
                <p id='user'>".$_SESSION['nombre']."</p>
                <p id='fecha'>".$this->c_date."</p>
                <p id='comentario'>".$this->texto."</p>";

            if(isset($_SESSION['login']) && $_SESSION['esModerador']){
                $html .= " 
                <div class='botones'>
                    <a onclick='borrarComentario($conn->insert_id)'>Eliminar</a>
                </div>";
            }
            //Si es usuario puede reportarlo
            else if(isset($_SESSION['login']) && $_SESSION['esUser']){

                $autorComentario = $_SESSION['nombre'];

                $html .= "
                <div class='botones'>
                <a onclick='openMenu($conn->insert_id)' id='reportar'>Reportar</a>
                <ul class='subMenu' id='subMenu$conn->insert_id'>
                    <li><a onclick='reportarComentario(\"{$autorComentario}\",
                            $conn->insert_id, 1)'>Spam</a>
                    </li>
                    <li><a onclick='reportarComentario(\"{$autorComentario}\",
                            $conn->insert_id, 2)'>Ofensivo</a>
                    </li>
                </ul>
                </div>";
            }

            $html .= "</div>";

            return $html;
        } 
        else {
            return false;
        }
    }


    public function deleteComment($id_comment){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        
        $query=sprintf("DELETE FROM comments
                        WHERE id_comment = $id_comment"
        );


        if ( $conn->query($query) ){
            return true;
        } 
        else {
            return false;
        }
    }

    public function reportComment($id_autor_comment, $id_session, $id_comment, $cause){
        $app = Aplicacion::getInstance();
        $conn = $app->conexionBD();
        
        $query=sprintf("INSERT INTO reports(usr_that_reports, usr_reported)
                        VALUES('%s', '%s')",
                            $conn->real_escape_string($id_session),
                            $conn->real_escape_string($id_autor_comment)
        );


        if ( $conn->query($query) ){

            $id_report = $conn->insert_id;

            $query2=sprintf("INSERT INTO co_reports(id_report, cause, id_comment)
                            VALUES('%s', '%s', '%s')",
                $conn->real_escape_string($id_report),
                $conn->real_escape_string($cause),
                $conn->real_escape_string($id_comment)
            );



            if($conn->query($query2)){
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


}