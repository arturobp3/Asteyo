<?php

require_once('Form.php');
require_once('usuario.php');


class formularioLogin extends Form{

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
        $html .= '<label>Nombre de usuario:</label> <input type="text" name="nombreUsuario" placeholder="Nombre" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Contraseña:</label> <input type="password" name="password" placeholder="Contraseña" />';
        $html .= '</div>';

        $html .= '<div class="grupo-control"><button type="submit" name="login">Entrar</button></div>';

        $html .= '</div>';

        return $html;
    }

    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $username = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : null;

        if ( empty($username) ) {
            $erroresFormulario[] = "El nombre de usuario no puede estar vacío";
        }

        $password = isset($datos['password']) ? $datos['password'] : null;
        if ( empty($password) ) {
            $erroresFormulario[] = "El password no puede estar vacío.";
        }

        if (count($erroresFormulario) === 0) {
            //$app esta incluido en config.php


            $usuario = Usuario::buscaUsuario($username);
			
            if (!$usuario) {
                $erroresFormulario[] = "El usuario o el password no coinciden";
            }
            else{
                if ($usuario->compruebaPassword($password)) {
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $username;
                    $_SESSION['esAdmin'] = strcmp($usuario->rol(), 'administrador') == 0 ? true : false;
                    $_SESSION['esUser'] = strcmp($usuario->rol(), 'normal') == 0 ? true : false;
                    $_SESSION['esModerador'] = strcmp($usuario->rol(), 'moderador') == 0 ? true : false;
                

                    //header('Location: index.php');
                    return "index.php";
                } else {
                    $erroresFormulario[] = "El usuario o el password no coinciden";
                }
            }
        }

        return $erroresFormulario;
    }

}