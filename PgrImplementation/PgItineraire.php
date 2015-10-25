<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 04/10/2015
 * Time: 15:09
 */

namespace PgrImplementation;


use Exception\BadEtapeException;
use Itineraire\ICalculItineraire;
use Itineraire\IEtape;
use Itineraire\Trajet;

class PgItineraire implements ICalculItineraire
{
    /**
     * @var IEtape L'étape de départ de l'itinéraire
     */
    private $depart;

    /**
     * @var IEtape L'étape d'arrivée de l'itinéraire
     */
    private $arrivee;

    /**
     * @var PgMapTable map dans laquelle calculer un itinéraire
     */
    private $map;

    /**
     * @var \PDO connexion à la base de données
     */
    private $connexion;

    public function __construct(IEtape $depart, IEtape $arrivee, PgMapTable $map)
    {
        if($depart !== null && $arrivee !== null && $map !== null)
        {
            if($depart->getMapName() == $arrivee->getMapName())
            {
                $this->depart = $depart;
                $this->arrivee = $arrivee;

                $this->map = $map;
                $this->connexion = $this->map->getConnexion();
            }
            else
            {
                throw new BadEtapeException("L'étape de départ doit se trouver sur la même map que l'étape d'arrivée.",
                    $depart, $arrivee);
            }
        }
        else
        {
            throw new \Exception("Les paramètres renseignés ont été mal initialisés.");
        }

    }

    public function calculerItineraire()
    {
        $resCalculerItineraire = $this->connexion->query(
                "SELECT id2 as edge, st_x(vert.the_geom) as x, st_y(vert.the_geom) as z, nom_route, dest.nom as etape,
                    dest.type as type
                    FROM pgr_dijkstra(
                    'SELECT id, source, target, st_length(the_geom) as cost FROM {$this->map->getSegmentsTableName()}',
                    {$this->depart->getIdPoint()}, {$this->arrivee->getIdPoint()}, false, false) as di
                    LEFT JOIN {$this->map->getSegmentsTableName()} pt ON di.id2 = pt.id
                    LEFT JOIN {$this->map->getVerticesTableName()} vert ON di.id1 = vert.id
                    LEFT JOIN {$this->map->getDestinationsTableName()} dest ON st_dwithin(dest.the_geom, vert.the_geom, 1)");

        if($resCalculerItineraire != false && $resCalculerItineraire->rowCount() > 0)
        {
            return new Trajet($resCalculerItineraire->fetchAll(\PDO::FETCH_ASSOC));
        }
        else
        {
            return false;
        }
    }

    /**
     * @return IEtape
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * @return IEtape
     */
    public function getArrivee()
    {
        return $this->arrivee;
    }
}