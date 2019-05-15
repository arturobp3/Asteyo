<?php

require_once('Form.php');
require_once('usuario.php');
require_once('Meme.php');
require_once('Logros.php');
require_once('Hashtag.php');
require_once('usuario.php');


class formularioSubirMeme extends Form{

    public function  __construct($formId, $opciones = array() ){
        parent::__construct($formId, $opciones);
    }

    
    protected function generaCamposFormulario($datosIniciales){

        $html = '<div class="formulario">';

        $html .= '<div class="grupo-control">';                            
        $html .= '<label>Título del meme:</label> <input type="text" name="tituloMeme" placeholder="Título"  />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<input type="file" name="imagen" accept="image/*"/>';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<label>Escribe tus hashtags separados por espacio</label> <input type="text" name="hashtags" placeholder="#... " />';
        $html .= '</div>';

        $html .= '<div class="grupo-control">';
        $html .= '<button type="submit" name="meme">Enviar</button>';
        $html .= '</div>';

        $html .= '</div>';

        return $html;
    }

    //La información que maneja esta función ha sido enviada por el método POST (clase Form.php)
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

        //Nombre temporal de la ruta en la cual se almacena el fichero subido.
        $imagetemp = $_FILES["imagen"]["tmp_name"];

        $hashtags=array();
        $hashtags= isset($_POST['hashtags'])? explode(" ", $_POST['hashtags'] ) : null;
        $formato = true;

        if(!empty($hashtags)){
            foreach ($hashtags as $key => $values) {
                $formato = (substr($values, 0, 1)=== '#' && $formato)? true : false;
            } 
        }
        else{
            $erroresFormulario[]='Tienes que introducir al menos un hashtag.';
        }
        
        
        if(!$formato){
            $erroresFormulario[]='El formato de los hashtags no es el adecuado.';
        }

        if (count($erroresFormulario) === 0) {
        
            if(is_uploaded_file($imagetemp)) {
                //Se guardan los datos en la BBDD
                $meme = Meme::crea($tituloMeme, $num_megustas, $id_autor, $datetime);

                $ruta = "uploads/".$id_autor."/".$meme->id().".jpg"; 

                $logro = Logros::logroSubir($id_autor);

                if($meme && move_uploaded_file($imagetemp , $ruta)) {
                    //comprobar la extensión

                    echo "Meme subido correctamente";
                    //comprobar si existe el hashtag si no se sube y si ya existe
                    foreach ($hashtags as $key => $value) {
                        $hashtag = Hashtag::create($value, $meme->id());
                        
                    }
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


           # return "index.php";
        }

        return $erroresFormulario;   
    }

}