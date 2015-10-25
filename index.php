<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

// Doit impérativement être exécuté pour pouvoir charger les classes
//spl_autoload_extensions(".php");
//spl_autoload_register();

function my_autoload ($pClassName) {
    $pClassName = str_replace("\\", "/", $pClassName);
    include_once(__DIR__ . "/" . $pClassName . ".php");
}
spl_autoload_register("my_autoload");

try
{
    $co = new PgrImplementation\PgDefaultConnexion();
    header('Content-Type: image/svg+xml');
    header('charset=utf-8');
    header('Vary: Accept-Encoding');
    $time_start = microtime(true);

    $map = new PgrImplementation\PgMapTable("V5", $co, false);

    $point = new PgrImplementation\PgEtapeNommee("SigiCoal III", $map);
    $point2 = new PgrImplementation\PgEtapeNommee("PCDPC", $map);

    $itineraire = new PgrImplementation\PgItineraire($point, $point2, $map);
    $trajet = $itineraire->calculerItineraire();

    //var_dump($trajet->getPoints());
    //$trajet->getDistance();
    echo \Itineraire\Renderer\Svg\SvgRenderer::asSVG($trajet);

    $time_end = microtime(true);


    //echo $time_end - $time_start;



}
catch (Exception $e)
{
    echo $e->getMessage();
}