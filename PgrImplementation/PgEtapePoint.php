<?php
/**
 * Created by PhpStorm.
 * User: moribus
 * Date: 10/09/2015
 * Time: 23:34
 */

namespace PgrImplementation;

use Exception\EtapeException;

/**
 * Représente une étape sous forme de point non connecté
 * au réseau routier.
 * @package Itineraire
 */
class PgEtapePoint extends PgEtape
{
    /**
     * @var array coordonnée du point non relié au réseau routier
     * sous forme de tableau associatif {x, y, z}
     */
    private $pointEloigne;

    /**
     * Construit une nouvelle étape éloignée de la route située
     * aux coordonnées x y z.
     * Si aucun sommet du réseau routier ne se trouve dans $rayonRecherche
     * autour du point, une exception est levée.
     * @param array $pointEloigne un point non relié au réseau routier autour duquel
     * chercher la route la plus proche afin de le relier à celle-ci
     * @param $rayonRecherche double périmètre dans lequel chercher le sommet le
     * plus proche du réseau routier autour de $pointEloigne. Unité de mesure en mètre
     * @param PgMapTable $map
     * @throws EtapeException
     * @throws \Exception
     * @throws EtapeException
     */
    public function __construct(array $pointEloigne, $rayonRecherche, PgMapTable $map)
    {
        parent::__construct(self::getNearestPoint($pointEloigne,
                            $rayonRecherche, $map), $map);
        $this->pointEloigne = $pointEloigne;
    }

    /**
     * Recherche le sommet de la route le plus proche du $point dans un rayon
     * de $rayonRecherche
     * @param array $point
     * @param $perimRecherche
     * @param PgMapTable $map
     * @return string
     * @throws EtapeException
     * @throws \Exception
     */
    public static function getNearestPoint(array $point, $perimRecherche, PgMapTable $map)
    {
        if(array_key_exists("x", $point) && array_key_exists("y", $point)
            && array_key_exists("z", $point))
        {
            $reqNearestPoint = $map->getConnexion()->query("select id from {$map->getVerticesTableName()}
                WHERE st_dwithin(st_makepoint({$point['x']}, {$point['z']}), the_geom, $perimRecherche)
                LIMIT 1");

            if(!is_bool($reqNearestPoint) && $reqNearestPoint->rowCount() > 0)
            {
                $nearestPoint = $reqNearestPoint->fetchColumn(0);

                return intval($nearestPoint);
            }
            else
            {
                throw new EtapeException("Aucun sommet du réseau routier ne se trouve à proximité.");
            }
        }
        else
        {
            throw new \Exception("Le tableau doit contenir les coordonnées x y z.");
        }
    }
}