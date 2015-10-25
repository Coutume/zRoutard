<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 25/10/2015
 * Time: 14:36
 */

namespace PgrImplementation;

/**
 * Class GisManager
 * NB : GIS = Geographical Information System
 * Gère les objets géographiques d'une map (routes, destinations, ...)
 * @package PgrImplementation
 */
class GisManager
{
    /**
     * @var PgMapTable la map pour laquelle gérer les objets géographiques
     */
    private $map;

    /**
     * @var \PDO Connexion à la base de données contenant les objets géographiques
     */
    private $connexion;

    /**
     * Construit un nouveau gestionnaire d'objets géographiques
     * @param PgMapTable $map la map dans laquelle gérer les objets géographiques
     */
    public function __construct(PgMapTable $map)
    {
        $this->map = $map;
        $this->connexion = $this->map->getConnexion();
    }

    /**
     * Récpère toutes les destinations disponibles sur la map
     * @return array
     */
    public function getAllDestination()
    {
        $reqDest = $this->connexion->query("SELECT nom, type, x, z FROM {$this->map->getDestinationsTableName()}");

        return $reqDest->fetchAll(\PDO::FETCH_ASSOC);
    }
}