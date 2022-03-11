<?php

/**
 * Funcion para carga el arcihvo .php necesario en tiempo de ejecucion
 *
 * @author Sergio
 * @return void
 */

function cargador($clase)
{
    $paths = array("controladores", "helper", "models", "interfaces");
    foreach ($paths as $path) {
        if (file_exists("$path/$clase.php")) {
            require_once "$path/$clase.php";
        }
    }
}
spl_autoload_register("cargador");

define("DB_SERVER", "localhost");
define("DB_PORT", "3306");
define("DB_NAME", "estadisticas-videojuegos");
define("DB_USER", "root");
