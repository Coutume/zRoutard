<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 19/10/2015
 * Time: 00:16
 */
namespace Itineraire;

interface ICalculItineraire
{
    /**
     * @return Trajet|bool l'objet trajet si un itinéraire est possible, false sinon
     */
    public function calculerItineraire();

    /**
     * @return IEtape l'étape de départ
     */
    public function getDepart();

    /**
     * @return IEtape l'étape d'arrivée
     */
    public function getArrivee();
}