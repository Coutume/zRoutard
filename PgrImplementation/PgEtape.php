<?php
/**
 * Created by PhpStorm.
 * User: moribus
 * Date: 06/09/2015
 * Time: 16:49
 */

namespace PgrImplementation;


use Exception;
use Exception\EtapeException;
use Itineraire\IEtape;
use Topologie\IPoint;
use Topologie\Point;

class PgEtape implements IEtape
{
    /**
     * @var int id du sommet routier
     */
    private $idPoint;

    /**
     * @var IPoint Coordonnées de l'étape
     */
    private $point;

    /**
     * @var PgMapTable map dans laquelle se trouve l'étape
     */
    private $map;

    /**
     * @var \PDO Connexion à la BDD PostGres
     */
    private $connexion;

    /**
     * Instancie une étape de l'itinéraire se situant au sommet
     * ayant pour id $point
     * @param $idPoint
     * @param PgMapTable $map
     * @throws EtapeException
     * @throws Exception
     */
    function __construct($idPoint, PgMapTable $map)
    {
        if(isset($map))
        {
            $this->map = $map;
            $this->connexion = $this->map->getConnexion();
            if(is_int($idPoint))
            {
                $this->idPoint = $idPoint;
                $point = $this->checkPointExists();
                if($point != false)
                {
                    $this->point = $point;
                }
                else { throw new EtapeException('Le point numéro'. $this->idPoint. 'n\'existe pas.');}

            }
            else { throw new Exception('L\'id du point doit être un entier');}
        }
        else { throw new Exception("La variable map doit être définie");}
    }

    /**
     * Vérifie si un sommet routier existe
     * @return bool|IPoint le point correspondant s'il existe, false s'il n'existe pas
     */
    private function checkPointExists()
    {
        $reqExiste = $this->connexion->query("select st_x(the_geom) as x, st_y(the_geom) as z
                                              from {$this->map->getVerticesTableName()} WHERE id = {$this->idPoint}");
        if($reqExiste->rowCount() == 0)
        {
            return false;
        }

        $tab = $reqExiste->fetch(\PDO::FETCH_ASSOC);
        return new Point($tab['x'], $tab['z']);
    }

    /**
     * @return int l'id du sommet correspondant à l'étape
     */
    public function getIdPoint()
    {
        return $this->idPoint;
    }

    /**
     * @return string Le nom de la map où se trouve cette étape
     */
    public function getMapName()
    {
        return $this->map->getMapName();
    }

    /**
     * @return string Retourne un nom représentant l'étape
     */
    public function getName()
    {
        return "point (x: {$this->point->getX()}, z: {$this->point->getX()})";
    }
}