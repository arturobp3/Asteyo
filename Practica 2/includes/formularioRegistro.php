<?php

require_once('form.php');
require_once('usuario.php');

class formularioRegistro extends Form{

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

        $html = '<fieldset>';
        $html .= '<div class="grupo-control">';
        $html .= '<label>Nombre de usuario:</label> <input class="control" type="text" name="nombreUsuario" />';
        $html .= '</div>';
        $html .= '<div class="grupo-control">';
        $html .= '<label>Nombre completo:</label> <input class="control" type="text" name="nombre" />';
        $html .= '</div>';
        $html .= '<div class="grupo-control">';
        $html .= '<label>Password:</label> <input class="control" type="password" name="password" />';
        $html .= '</div>';
        $html .= '<div class="grupo-control"><label>Vuelve a introducir el Password:</label> <input class="control" type="password" name="password2" /><br /></div>';
        $html .= '<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>';
        $html .= '</fieldset>';
        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $nombreUsuario = isset($_POST['nombreUsuario']) ? $_POST['nombreUsuario'] : null;
        
        if ( empty($nombreUsuario) || mb_strlen($nombreUsuario) < 5 ) {
            $erroresFormulario[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $erroresFormulario[] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $erroresFormulario[] = "Los passwords deben coincidir";
        }
        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::crea($nombreUsuario, $nombre, $password, 'user');
            
            if (! $usuario ) {
                $erroresFormulario[] = "El usuario ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $nombreUsuario;
                //header('Location: index.php');
                return "index.php";
            }
        }

        return $erroresFormulario;

    }

}