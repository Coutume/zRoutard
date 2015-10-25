<?php
/**
 * Created by PhpStorm.
 * User: moribus
 * Date: 14/09/2015
 * Time: 18:13
 */

namespace Itineraire;


interface IEtape
{
    /**
     * Retourne l'id du sommet routier associé à cette étape
     * @return int
     */
    public function getIdPoint();

    /**
     * @return string Le nom de la map où se trouve cette étape
     */
    public function getMapName();

    /**
     * @return string Retourne un nom représentant l'étape
     */
    public function getName();

}