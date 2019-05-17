<?php

namespace es\ucm\fdi\aw;

/**
 * Clase de  de gestión de formularios.
 *
 * Gestión de token CSRF está basada en: https://www.owasp.org/index.php/PHP_CSRF_Guard
 */
class Form
{

  /**
   * Sufijo para el nombre del parámetro de la sesión del usuario donde se almacena el token CSRF.
   */
  const CSRF_PARAM = 'csrf';

  /**
   * Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
   */
  private $formId;

  private $ajax;

  /**
   * URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el envío del formulario.
   */
  private $action;

  /**
   * Valor del atributo "class" de la etiqueta &lt;form&gt; asociada al formulario. Si este parámetro incluye la cadena "nocsrf" no se generá el token CSRF para este formulario.
   */
  private $classAtt;

  /**
   * Valor del parámetro enctype del formulario.
   */
  private $enctype;

  /**
   * Se encarga de orquestar todo el proceso de creación y procesamiento de un formulario web.
   *
   * @param string $formId Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
   *
   * @param string $action (opcional) URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el envío del formulario. Por defecto la URL es $_SERVER['PHP_SELF']
   *
   * @param string $class (opcional) Valor del atributo "class" de la etiqueta &lt;form&gt; asociada al formulario. Si este parámetro incluye la cadena "nocsrf" no se generá el token CSRF para este formulario.
   *
   * @param string enctype (opcional) Valor del parámetro enctype del formulario.
   */
  public function __construct($formId, $opciones = array() )
  {
    $this->formId = $formId;

    $opcionesPorDefecto = array( 'ajax' => false, 'action' => null, 'class' => null, 'enctype' => null );
    $opciones = array_merge($opcionesPorDefecto, $opciones);

    $this->ajax     = $opciones['ajax'];
    $this->action   = $opciones['action'];
    $this->classAtt = $opciones['class'];
    $this->enctype  = $opciones['enctype'];
    
    if ( !$this->action ) {
      $app = Aplicacion::getSingleton();
      $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
      $this->action = $app->resuelve($this->action);
    }
  }
  
  public function gestiona()
  {
    
    if ( ! $this->formularioEnviado($_POST) ) {
      return $this->generaFormulario();
    } else {
      // Valida el token CSRF si es necesario (hay un token en la sesión asociada al formulario)
      $tokenRecibido = $_POST['CSRFToken'] ?? FALSE;
      
      if ( ($errores = $this->csrfguard_ValidateToken($this->formId, $tokenRecibido)) !== TRUE ) { 
          if ( ! $this->ajax ) {
            return $this->generaFormulario($errores, $_POST);
          } else {
            return $this->generaHtmlErrores($errores);
          }
      } else  {
        $result = $this->procesaFormulario($_POST);
        if ( is_array($result) ) {
          // Error al procesar el formulario, volvemos a mostrarlo
          if ( ! $this->ajax ) {
            return $this->generaFormulario($result, $_POST);
          } else {
            return $this->generaHtmlErrores($result);
          }
        } else {
          if ( ! $this->ajax ) {
            header('Location: '.$result);
          } else {
            return $result;
          }
        }
      }
    }  
  }

  /**
   * Devuelve un <code>string</code> con el HTML necesario para presentar los campos del formulario. Es necesario asegurarse que como parte del envío se envía un parámetro con nombre <code$formId</code> (i.e. utilizado como valor del atributo name del botón de envío del formulario).
   */
  protected function generaCamposFormulario ($datos)
  {
    return '';
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos)
  {

  }

  /**
   * Función que verifica si el usuario ha enviado el formulario. Comprueba si existe el parámetro <code>$formId</code> en <code>$params</code>.
   *
   * @param array $params Array que contiene los datos recibidos en el envío formulario.
   *
   * @return boolean Devuelve <code>TRUE</code> si <code>$formId</code> existe como clave en <code>$params</code>
   */
  private function formularioEnviado(&$params)
  {
    return ($params['action'] ?? '') == $this->formId;
  } 

  /**
   * Función que genera el HTML necesario para el formulario.
   *
   *
   * @param array $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
   *
   * @param array $datos (opcional) Array con los valores por defecto de los campos del formulario.
   */
  private function generaFormulario($errores = array(), &$datos = array())
  {

    $html= $this->generaListaErrores($errores);

    $html .= '<form enctype="multipart/form-data" method="POST" action="'.$this->action.'" id="'.$this->formId.'"';
    if ( $this->classAtt ) {
      $html .= ' class="'.$this->classAtt.'"';
    }
    if ( $this->enctype ) {
      $html .= ' enctype="'.$this->enctype.'"';
    }
    $html .=' >';
    
    // Se genera el token CSRF si el usuario no solicita explícitamente lo contrario.
    if ( ! $this->classAtt || strpos($this->classAtt, 'nocsrf') === false ) {
      $tokenValue = $this->csrfguard_GenerateToken($this->formId);
      $html .= '<input type="hidden" name="CSRFToken" value="'.$tokenValue.'" />';
    }

    $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';
    
    $html .= $this->generaCamposFormulario($datos);
    $html .= '</form>';
    return $html;
  }

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

  private function csrfguard_GenerateToken($formId)
  {
    if ( ! isset($_SESSION) ) {
      throw new Exception('La sesión del usuario no está definida.');
    }
    
    if ( function_exists('hash_algos') && in_array('sha512', hash_algos()) ) {
      $token = hash('sha512', mt_rand(0, mt_getrandmax()));
    } else {
      $token=' ';
      for ($i=0;$i<128;++$i) {
        $r=mt_rand(0,35);
        if ($r<26){
          $c=chr(ord('a')+$r);
        } else{ 
          $c=chr(ord('0')+$r-26);
        } 
        $token.=$c;
      }
    }

    $_SESSION[$formId.'_'.self::CSRF_PARAM]=$token;

    return $token;
  }

  private function csrfguard_ValidateToken($formId, $tokenRecibido)
  {
    if ( ! isset($_SESSION) ) {
      throw new Exception('La sesión del usuario no está definida.');
    }
    
    $result = TRUE;
    
    if ( isset($_SESSION[$formId.'_'.self::CSRF_PARAM]) ) {
      if ( $_SESSION[$formId.'_'.self::CSRF_PARAM] !== $tokenRecibido ) {
        $result = array();
        $result[] = 'Has enviado el formulario dos veces';
      }
      $_SESSION[$formId.'_'.self::CSRF_PARAM] = ' ';
      unset($_SESSION[$formId.'_'.self::CSRF_PARAM]);
    } else {
      $result = array();
      $result[] = 'Formulario no válido';
    }
      return $result;
  }
}
