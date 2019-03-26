<?php

/**
 * Clase base para la gestión de formularios.
 *
 * Además de la gestión básica de los formularios.
 */
abstract class Form
{

    /**
     * @var string Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y 
     * como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
     */
    private $formId;

    /**
     * @var string URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el 
     * envío del formulario.
     */
    private $action;

    /**
     * Crea un nuevo formulario.
     *
     * Posibles opciones:
     * <table>
     *   <thead>
     *     <tr>
     *       <th>Opción</th>
     *       <th>Valor por defecto</th>
     *       <th>Descripción</th>
     *     </tr>
     *   </thead>
     *   <tbody>
     *     <tr>
     *       <td>action</td>
     *       <td><code>$_SERVER['PHP_SELF']</code></td>       
     *       <td>URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará
     *          el envío del formulario.</td>
     *     </tr>
     *   </tbody>
     * </table>

     * @param string $formId    Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al
     *                          formulario y como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
     *
     * @param array $opciones (ver más arriba).
     */
    public function __construct($formId, $opciones = array() )
    {
        $this->formId = $formId;

        $opcionesPorDefecto = array( 'action' => null, );

        //Machaca los campos que de opcionesPorDefecto que esten definidos en opciones
        $opciones = array_merge($opcionesPorDefecto, $opciones);

        $this->action   = $opciones['action'];

        
        if ( !$this->action ) {
            //Pagina en la que estamos ahora si no hay una accion. 'PHP_SELF' indica la pagina actual
            $this->action = htmlentities($_SERVER['PHP_SELF']);
        }
    }
  
    /**
     * Se encarga de orquestar todo el proceso de gestión de un formulario.
     */
    public function gestiona()
    {   
 
        if ( ! $this->formularioEnviado($_POST) ) { //Estamos con GET: Generamos el formulario
            echo $this->generaFormulario();
        } 
        else {   //Si tenemos un formulario generado
            $result = $this->procesaFormulario($_POST);
            if ( is_array($result) ) {
                echo $this->generaFormulario($result, $_POST);
            } else {
                header('Location: '.$result); //Siguiente pagina
                exit();
            }
        }  
    }

    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario($datosIniciales)
    {
        return '';
    }

    /**
     * Procesa los datos del formulario.
     *
     * @param string[] $datos Datos enviado por el usuario (normalmente <code>$_POST</code>).
     *
     * @return string|string[] Devuelve el resultado del procesamiento del formulario, normalmente una URL a la que
     * se desea que se redirija al usuario, o un array con los errores que ha habido durante el procesamiento del formulario.
     */
    protected function procesaFormulario($datos)
    {
        //Tiene que devolver una lista de errores si no. Función de abajo
        return array();
    }
  
    /**
     * Función que verifica si el usuario ha enviado el formulario.
     * Comprueba si existe el parámetro <code>$formId</code> en <code>$params</code>.
     *
     * @param string[] $params Array que contiene los datos recibidos en el envío formulario.
     *
     * @return boolean Devuelve <code>true</code> si <code>$formId</code> existe como clave en <code>$params</code>
     */
    private function formularioEnviado(&$params)
    {
        return isset($params['action']) && $params['action'] == $this->formId;
    } 

    /**
     * Función que genera el HTML necesario para el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @param string[] $datos (opcional) Array con los valores por defecto de los campos del formulario.
     *
     * @return string HTML asociado al formulario.
     */
    private function generaFormulario($errores = array(), &$datos = array())
    {

        $html= $this->generaListaErrores($errores);

        $html .= '<form enctype="multipart/form-data" method="POST" action="'.$this->action.'" id="'.$this->formId.'" >';
        $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

        $html .= $this->generaCamposFormulario($datos);
        $html .= '</form>';
        return $html;
    }

    /**
     * Genera la lista de mensajes de error a incluir en el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @return string El HTML asociado a los mensajes de error.
     */
    private function generaListaErrores($errores)
    {
        $html='';
        $numErrores = count($errores);
        if (  $numErrores == 1 ) {
            $html .= "<ul><li>".$errores[0]."</li></ul>";
        } else if ( $numErrores > 1 ) {
            $html .= "<ul><li>";
            $html .= implode("</li><li>", $errores);
            $html .= "</li></ul>";
        }
        return $html;
    }
}
