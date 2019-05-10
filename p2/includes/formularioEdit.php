<?php

require_once('Form.php');
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

        $html .= '<div class="grupo-control">';
        $html .='<label>Vuelve a introducir la nueva contraseña:</label>';
        $html .='<input class="control" type="password" name="new-password2"/>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Cambia tu foto de perfil</label>';
        $html .= '<input type="file" name="imagen" accept="image/*"/>';
        $html .= '</div>';

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

        $imagenPerfil = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;

        //Comprueba si el archivo seleccionado es una imagen y no otra cosa distinta
        $imageExtension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        //Ha habido un cambio en la imagen
        $cambioImagen = false;
        if($imageExtension != ""){
            
            if($imageExtension != "jpg"){
                $erroresFormulario[] = "Solo se permiten archivos con extension: JPG";
            }
            else{
                $cambioImagen = true;
            }
        }

        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
            $hacerUpdate = false;
            
            if ($new && $old && $new2){
                if ($usuario->compruebaPassword($old)){
                    $usuario->cambiaPassword($new);
                    echo "Contraseña cambiada correctamente";
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

                echo "Nombre de usuario cambiado correctamente";

                $_SESSION['nombre']=$username;
            }

            if($cambioImagen){
                //Nombre temporal de la ruta en la cual se almacena el fichero subido.
                $imagetemp = $_FILES["imagen"]["tmp_name"];

                //Borramos la foto antigua: ./uploads/nombre/fotoPerfil.Extension
                if (file_exists('./uploads/'.$_SESSION['nombre'].'/fotoPerfil.jpg')) {
                    if(unlink('./uploads/'.$_SESSION['nombre'].'/fotoPerfil.jpg')){
                        if(move_uploaded_file($imagetemp,"uploads/".$_SESSION['nombre']."/fotoPerfil.jpg")){
                            echo "Imagen cambiada correctamente";
                        }
                        else{
                            $erroresFormulario[]="Ha habido un error al cambiar la imagen.";
                        }
                    }
                    else{
                       $erroresFormulario[]="Ha habido un error al borrar la imagen antigua.";
                    }
                }
                else{
                    if(move_uploaded_file($imagetemp,"uploads/".$_SESSION['nombre']."/fotoPerfil.jpg")){
                        echo "Imagen subida correctamente";
                    }
                    else{
                         $erroresFormulario[]="Ha habido un error al subir la imagen.";
                    }
                }
                
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
