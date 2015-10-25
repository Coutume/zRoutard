<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 25/10/2015
 * Time: 14:31
 */

/**
 * @param string $pClassName function de chargement automatique
 * des classes.
 */
function my_autoload ($pClassName) {
    $pClassName = str_replace("\\", "/", $pClassName);
    include_once(__DIR__ . "/" . $pClassName . ".php");
}
spl_autoload_register("my_autoload");