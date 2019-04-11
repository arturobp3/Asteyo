<?php

require_once('form.php');
require_once('usuario.php');

class formularioEdit extends Form{

    public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }


    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario($datosIniciales){

        $html = '<div class="formulario">';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Nuevo nombre de usuario:</label> <input class="control" type="text" name="username" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Contraseña actual:</label> <input class="control" type="password" name="old-password" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Contraseña nueva:</label> <input class="control" type="password" name="new-password" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control"><label>Vuelve a introducir la nueva contraseña:</label> <input class="control" type="password" name="new-password2" /><br /></div>';

        $html .= '<div class="grupo-control"><button type="submit" name="registro">Editar</button></div>';

        $html .= '</div>';
        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        

        $username = isset($_POST['username']) ? $_POST['username'] : false;
        if ($username && mb_strlen($username) < 5 ) {
            $erroresFormulario[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $old = isset($_POST['old-password']) ? $_POST['old-password'] : false;
        
        $new = isset($_POST['new-password']) ? $_POST['new-password'] : false;
        if ($new && mb_strlen($new) < 5 ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $new2 = isset($_POST['new-password2']) ? $_POST['new-password2'] : false; 
        if ($new2 && $new2 !== $new){
            $erroresFormulario[] = "Las contraseñas deben ser iguales.";
        }

        if (!$old || !$new || !$new2){
            if ($old || $new || $new2){
                $erroresFormulario[] = "Para campar la Password deben estar rellenos los tres campos";
            }
        }
        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
            $hacerUpdate = false;
            
            if ($new && $old && $new2){
                if ($usuario->compruebaPassword($old)){
                    $usuario->cambiaPassword($new);
                    $hacerUpdate=true;
                }
                else{
                    $erroresFormulario[]="La contraseña actual no coincide.";
                    return $erroresFormulario ;
                }
            }
            
            if ($username){
                $existe = Usuario::buscaUsuario($username)? true : false;
                if($existe){
                   $erroresFormulario[]="Ese nombre ya existe.";
                    return  $erroresFormulario;
                }
                $usuario->setUserName($username);

                $hacerUpdate=true;

                $carpetaVieja='./uploads/'.$_SESSION['nombre'];
                $carpetaNueva='./uploads/'.$username;
                rename($carpetaVieja, $carpetaNueva);

                $_SESSION['nombre']=$username;

            }
            
            if($hacerUpdate){
                $usuario->guarda($usuario);

            }
            #return "index.php";
            
        }

        return $erroresFormulario;

    }

}
?>
