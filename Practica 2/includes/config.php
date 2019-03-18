<?php

require_once('aplicacion.php');

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'ejercicio3');
define('BD_USER', 'ejercicio3');
define('BD_PASS', 'ejercicio3');


/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
session_start();
ini_set('default_charset', 'UTF-8');
setlocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_get();

// Inicializa la aplicación
$app = Aplicacion::getInstance();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));


register_shutdown_function(array($app, 'shutdown'));


/**
 * An example of a project-specific implementation.
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Foo\Bar\Baz\Qux;
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'include';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '\fdi';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});