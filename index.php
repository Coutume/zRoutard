<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

// Doit impérativement être exécuté pour pouvoir charger les classes
include 'autoload.php';

// TODO Revoir la structure de l'index
try
{
    // Initialisation de la connexion à la base de données PostGres
    // renseignée dans le fichier PgrImplementation/config.ini
    $co = new PgrImplementation\PgDefaultConnexion();

    // Création de l'objet gérant l'accès aux tables d'une map
    $map = new PgrImplementation\PgMapTable("V5", $co, false);

    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        header('Content-Type: image/svg+xml');
        header('charset=utf-8');
        header('Vary: Accept-Encoding');

        if(isset($_POST['depart']))
        {

            $depart = new PgrImplementation\PgEtapeNommee($_POST['depart'], $map);

            if(isset($_POST['arrivee']))
            {
                $arrivee = new \PgrImplementation\PgEtapeNommee($_POST['arrivee'], $map);

                $itineraire = new PgrImplementation\PgItineraire($depart, $arrivee, $map);
                $trajet = $itineraire->calculerItineraire();

                echo \Itineraire\Renderer\Svg\SvgRenderer::asSVG($trajet);
            }
        }
    }
    else
    {
        header('Content-Type: text/html');
        header('charset=utf-8');
        header('Vary: Accept-Encoding');
        $gis = new \PgrImplementation\GisManager($map);
        $destinations = $gis->getAllDestination();

        include 'templatePageTest.php';
    }
}
catch (Exception $e)
{
    echo $e->getMessage();
}