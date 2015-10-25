<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 06/09/2015
 * Time: 20:21
 */

namespace PgrImplementation;

use Exception\EtapeException;

class PgEtapeNommee extends PgEtape
{
    /**
     * @var string nom de l'étape
     */
    private $nom;

    /**
     * Construit une nouvelle étape à l'endroit nommé $nom
     * @param string $nom le nom de l'endroit à partir duquel créer une étape
     * @param PgMapTable $map la map sur laquelle se trouve l'étape
     * @throws EtapeException
     * @throws \Exception
     */
    public function __construct($nom, PgMapTable $map)
    {
        parent::__construct(PgEtapeNommee::checkDestinationExists($nom, $map), $map);
        $this->nom = $nom;
    }

    public static function checkDestinationExists($nom, PgMapTable $map)
    {
        if(is_string($nom))
        {
            // Récupération du point
            $reqNom = $map->getConnexion()->query("SELECT vert.id FROM {$map->getVerticesTableName()} vert
                                            INNER JOIN {$map->getDestinationsTableName()} dest ON dest.the_geom = vert.the_geom
                                             WHERE dest.nom = '$nom'");

            if($reqNom->rowCount() > 0)
            {
                $id = $reqNom->fetchColumn(0);
                return intval($id);
            }
            else { throw new EtapeException("Le point '$nom' n'a pas été trouvé");}
        }
        else { throw new \Exception("le nom doit être une chaine de caractère");}
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->nom;
    }
}