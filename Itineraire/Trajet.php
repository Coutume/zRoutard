<?php
/**
 * Created by PhpStorm.
 * User: moribus
 * Date: 18/10/2015
 * Time: 19:47
 */

namespace Itineraire;

use Topologie\IPoint;
use Topologie\PointFactory;

/**
 * Class Trajet
 * Représente le résultat du calcul d'un itinéraire. Contient toutes les infos
 * sur un itinéraire tel que la distance, le parcours, ...
 * @package Itineraire
 */
class Trajet
{
    /**
     * @var IPoint[] tableau contenant le parcours sous forme de points.
     */
    private $parcours;

    /**
     * @var float Distance totale de l'itinéraire
     */
    private $distance;

    /**
     * @param array $parcours
     * @param string $cleX
     * @param string $cleZ
     * @throws \Exception
     */
    public function __construct(array $parcours, $cleX = 'x', $cleZ = 'z')
    {
        if (array_key_exists($cleX, $parcours[0]) && array_key_exists($cleZ, $parcours[0]))
        {
            $this->chargerPoint($parcours);
            $this->distance = false;
        }
        else
        {
            throw new \Exception("Le tableau renseigné ne contient pas toutes les valeurs de positions");
        }
    }

    /**
     * Calcule la distance totale du trajet.
     * ATTENTION : opération potentiellement lourde si tableau > 1000 éléments
     * @see Point::getDistance()
     * @return int
     */
    private function calculerDistance()
    {
        $distance = 0;

        if(count($this->parcours) > 1)
        {
            $prec_point = $this->parcours[0];
            for($i = 1; $i < count($this->parcours); $i++)
            {
                $dist = $prec_point->getDistance($this->parcours[$i]);
                $distance += $dist;

                $prec_point = $this->parcours[$i];
            }
        }

        return $distance;
    }

    /**
     * @return float La distance totale du trajet
     */
    public function getDistance()
    {
        if($this->distance == false)
        {
            $this->distance = $this->calculerDistance();
        }

        return $this->distance;
    }

    private function chargerPoint(array $points)
    {
        $this->parcours = array();
        for($i = 0; $i < count($points); $i++)
        {
            $point = PointFactory::creerPoint($points[$i]);

            $this->parcours[$i] = $point;
        }
    }

    /**
     * Retourne un tableau de points définissant le trajet
     * @return array tableau de points
     */
    public function getPoints()
    {
        $tab = array();
        foreach($this->parcours as $point)
        {
            $tab[] = $point->asArray();
        }

        return $tab;
    }

    /**
     * @see Trajet::parcours
     * @return IPoint[]
     */
    public function getParcours()
    {
        return $this->parcours;
    }
}
