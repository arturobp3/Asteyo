<?php

require_once('form.php');
require_once('usuario.php');
require_once('meme.php');


class formularioSubirMeme extends Form{

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
        $html .= '<label>Título del meme:</label> <input type="text" name="tituloMeme"  />';
        $html .= '</div>';
        $html .= '<div class="grupo-control">';
        $html .= '<input type="file" name="imagen" accept="image/*"/>';
        $html .= '</div>';
        $html .= '<div class="grupo-control">';
        $html .= '<button type="submit" name="meme">Enviar</button>';
        $html .= '</div>';
        $html .= '</fieldset>';

        return $html;
    }

    //La información que maneja esta función ha sido enviada por el método POST (clase form.php)
    protected function procesaFormulario($datos){

        $erroresFormulario = array();

        $tituloMeme = isset($_POST['tituloMeme']) ? $_POST['tituloMeme'] : null;
        
        if ( empty($tituloMeme) || mb_strlen($tituloMeme) > 100 ) {
            //Limite establecido por la base de datos
            $erroresFormulario[] = "El título escogido está vacio o sobrepasa el límite (100 caracteres).";
        }

        
        $imagenMeme = isset($_POST['imagen']) ? $_POST['imagen'] : null;


        //COMPROBAR SI ES UNA IMAGEN VALIDA?????
        /*
        if ( empty($imagenMeme) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $erroresFormulario[] = "El email no tiene un formato valido.";
        }*/
        

        //Likes del meme
        $num_megustas = 0;

        //Obtenemos el usuario actual
        $username = $_SESSION['nombre'];

        //Buscamos sus datos en la bbdd
        $usuario = Usuario::buscaUsuario($username);

        //Establecemos su id asociado
        $id_autor = $usuario->id();

        //Creamos la fecha actual se subida
        $datetime = date('Y-m-d H:i:s');

        //Ruta asociada a las carpetas de usuarios en la que cada una contiene los memes
        //subidos por cada uno.
        $link_img = "./mysql/img/".$username."/".$imagenMeme;


        if (count($erroresFormulario) === 0) {
        
            $meme = Meme::crea($tituloMeme, $num_megustas, $id_autor, $datetime, $link_img);

            if (! $meme ) {
                $erroresFormulario[] = "El meme ya existe";
            } else {

                //REALIZAMOS EL GUARDADO DE LA IMAGEN EN LA CARPETA ADECUADA
                /*$imagename = $_FILES['imagen']['name'];

                $imagetemp = $_FILES['imagen']['tmp_name'];


                if(is_uploaded_file($imagetemp)) {
                    if(move_uploaded_file($imagetemp, $link_img)) {
                        echo "Meme subido correctamente";
                    }
                    else {
                        echo "Ha habido un error al subir tu meme.";
                        exit();
                    }
                }
                else {
                    echo "Ha habido un error al subir tu meme";
                    exit();
                }*/


               //Aqui debería retornar a perfil cuando esté hecho
                return "index.php";
            }
        }

        return $erroresFormulario;   
    }

}