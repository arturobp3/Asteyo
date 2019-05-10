<?php

require_once('Form.php');
require_once('usuario.php');
require_once('Meme.php');
require_once('Hashtag.php');


class formularioAdmin extends Form{

    public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }

    
    protected function generaCamposFormulario($datosIniciales){

        $html = '<div class="formulario">';

        $html .= '<div class="grupo-control">';                            
        $html .= '<label>Nombre de usuario:</label> <input type="text" name="usuario" placeholder="Usuario"  />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<button type="submit" name="add">Añadir moderador</button>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<button type="submit" name="del">Eliminar moderador</button>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    //La información que maneja esta función ha sido enviada por el método POST (clase Form.php)
    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $user = isset($_POST['usuario']) ? $_POST['usuario'] : null;
        
        if ( empty($user)) {
            //Limite establecido por la base de datos
            $erroresFormulario[] = "El usuario debe estar rellenado.";
        }

        //Buscamos sus datos en la bbdd
        $usuario = Usuario::buscaUsuario($user);

        if($usuario){
            if(isset($_POST['add'])){
                $add = Usuario::cambiarRol("moderador", $user);
            }else{
                $del = Usuario::cambiarRol("normal", $user);
            }

            return "index.php";
        }else{
            $erroresFormulario[] = "El usuario no existe";
        }

       

        return $erroresFormulario;   
    }

}