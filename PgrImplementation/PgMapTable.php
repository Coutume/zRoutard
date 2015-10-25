<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 06/09/2015
 * Time: 17:29
 */

namespace PgrImplementation;

use Exception\MapException;

/**
 * Class PgMapTable
 * Représente une simple classe permettant de gérer les tables (au sens Sql) d'une map.
 * Actuellement permet de récupérer le nom des tables contenant les sommets,
 * les segments de routes, les routes et les destinations
 * ainsi que la connexion utilisée
 * @package Itineraire
 */
class PgMapTable
{
    private $map;
    private $connexion;

    /**
     * @param $map string le nom de la map
     * @param PgDefaultConnexion $connexion connexion à la BDD contenant les tables d'une map
     * @param bool $create si vrai, crée les tables d'une map si celles-ci n'existent pas
     * @throws \Exception Si l'un des paramètres est null
     */
    public function __construct($map, PgDefaultConnexion $connexion, $create)
    {
        if(is_string($map))
        {
            $this->map = $map;
            if(isset($connexion))
            {
                $this->connexion = $connexion;

                if(!$this->checkMapExists())
                {
                    if(is_bool($create) && $create)
                    {
                        $this->creerTableMap();
                    }
                    else { throw new MapException($map, "La map $map n'existe pas en base de données");}
                }
                // Si la map existe, il n'y a plus rien à faire :)
            }
            else { throw new \Exception("La connexion est invalide");}
        }
        else { throw new \Exception("La variable map est nulle");}
    }

    private function checkMapExists()
    {
        $existe = true;

        $req = $this->connexion->query("SELECT * FROM routezcraft_{$this->map}");
        if($req == false)
        {
            $existe = false;
        }

        return $existe;
    }

    public function getSegmentsTableName()
    {
        return 'routezcraft_'.$this->map;
    }

    private function creerTableMap()
    {
        // TODO coder la fonction permettant de générer les tables pour une map
        $checkPostGis = $this->connexion->query("SELECT PostGIS_full_version();");
        if($checkPostGis !== false)
        {
            //echo $checkPostGis->fetch(\PDO::FETCH_BOTH)[0];

            $checkPgRouting = $this->connexion->query("SELECT pgr_version();");
            if($checkPgRouting !== false)
            {
                //echo $checkPgRouting->fetch(\PDO::FETCH_BOTH)[0];
                $creerDest = '';
                include 'DBTemplate.php';
                $this->connexion->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
                $reqDest = $this->connexion->exec($creerDest);

                if($reqDest !== false)
                {
                    // TODO coder la création des autres tables
                }
            }
            else
            {
                throw new \Exception("Pgrouting n'est pas activé dans la base de données renseignées. Avez-vous installé la lib et crée l'extension dans la base ?");
            }
        }
        else
        {
            throw new \Exception("PostGis n'est pas activé dans la base de données renseignées. Avez-vous installé la lib et crée l'extension dans la base ?");
        }

        throw new \Exception("NON IMPLEMENTE");
    }

    public function getVerticesTableName()
    {
        return 'routezcraft_'. $this->map. '_vertices_pgr';
    }

    public function getDestinationsTableName()
    {
        return 'destination_'. $this->map;
    }

    public function getRoutesTableName()
    {
        return 'route_'. $this->map;
    }

    public function getConnexion()
    {
        return $this->connexion;
    }

    public function getMapName()
    {
        return $this->map;
    }
}