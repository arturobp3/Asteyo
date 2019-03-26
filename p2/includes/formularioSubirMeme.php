<?php

require_once('form.php');
require_once('usuario.php');
require_once('meme.php');


class formularioSubirMeme extends Form{

    public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }

    
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

        
        $imagenMeme = isset($_FILES['imagen']) ? $_FILES['imagen'] : null;

        //Comprueba si se ha seleccionado un archivo
        if ( empty($imagenMeme) || $_FILES['imagen']['size'] == 0 ) {
            $erroresFormulario[] = "¡Debes seleccionar una imagen!";
        }

        //Comprueba si el archivo seleccionado es una imagen y no otra cosa distinta
        $imageFileType = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $erroresFormulario[] = "Solo se permiten archivos con extension: JPG, JPEG, PNG ó GIF";
        }

        
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



        //PREPARAMOS LAS VARIABLES NECESARIAS PARA EL GUARDADO DE LA IMAGEN

        //Nombre original del fichero en la máquina del cliente.
        $imagename = $_FILES["imagen"]["name"];

        //Nombre temporal de la ruta en la cual se almacena el fichero subido.
        $imagetemp = $_FILES["imagen"]["tmp_name"];

        //Ruta asociada a las carpeta del usuario, que contiene los memes subidos.
        $link_img = "./mysql/img/".$username."/".$imagename;


        if (count($erroresFormulario) === 0) {
        
            if(is_uploaded_file($imagetemp)) {
                if(move_uploaded_file($imagetemp, $link_img)) {

                    //Se guardan los datos en la BBDD
                    $meme = Meme::crea($tituloMeme, $num_megustas, $id_autor, $datetime, $link_img);
                    echo "Meme subido correctamente";
                }
                else {
                    echo "Ha habido un error al subir tu meme.";
                    exit();
                }
            }
            else {
                echo "Ha habido un error al subir tu meme.";
                exit();
            }


            return "index.php";
        }

        return $erroresFormulario;   
    }

}