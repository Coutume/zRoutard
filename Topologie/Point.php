<?php
/**
 * Created by PhpStorm.
 * User: moribus
 * Date: 19/10/2015
 * Time: 18:23
 */

namespace Topologie;

/**
 * Class Point Représente un point sur la carte. Contient des fonctions pour
 * transformer les coordonnées au format Minecraft (z inversée)
 * @package Topologie
 */
class Point implements IPoint
{
    /**
     * @var int position X
     */
    private $x;

    /**
     * @var int position Y
     */
    private $y;

    /**
     * @var int position Z
     */
    private $z;

    /**
     * @var string Dimension du point (2D ou 3D)
     */
    private $dimension;

    /**
     * @param $x int
     * @param $z int
     * @param $y int
     */
    public function __construct($x, $z, $y = null)
    {
        if(is_numeric($x))
        {
            if(is_numeric($z))
            {
                $this->x = $x;
                $this->z = $z;

                if(!is_null($y) && is_numeric($y))
                {
                    $this->y= $y;
                    $this->dimension = "3D";
                }
                else
                {
                    $this->dimension = "2D";
                }
            }
        }
    }

    /**
     * @return int|string
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int|string
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @return int|string
     */
    public function getZ()
    {
        return $this->z;
    }

    /**
     * @return string
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Calcule la distance séparant ce point et $point
     * @param IPoint $point
     * @return float|int La distance entre cet objet point et $point
     * @throws \Exception Si les 2 points n'ont pas la même dimension (2D ou 3D)
     */
    public function getDistance(IPoint &$point)
    {
        $distance = 0;

        if($this->getDimension() === $point->getDimension())
        {
            switch($point->getDimension())
            {
                case '2D':
                    $distance = $this->get2dDistance($point);
                    break;
                case '3D':
                    $distance = $this->get3dDistance($point);
                    break;
            }
        }
        else
        {
            throw new \Exception("Les points doivent avoir la même dimension.");
        }

        return $distance;
    }

    public function get2dDistance(IPoint &$point)
    {
        $distance = sqrt( pow($point->getX() - $this->x,2)
                        + pow($point->getZ() - $this->z,2));

        return $distance;
    }

    public function get3dDistance(IPoint &$point)
    {
        $distance = sqrt( pow($point->getX() - $this->x,2)
                        + pow($point->getY() - $this->y,2)
                        + pow($point->getZ() - $this->z,2));

        return $distance;
    }

    /**
     * Renvoie la position au format géométrique standard :
     * - y et z inversée
     * - axe y inversé par rapport à l'axe z de Minecraft
     */
    public function getStandardPos()
    {
        $point = null;
        switch($this->dimension)
        {
            case '2D':
                $point = array(
                'x' => $this->x,
                'y' => $this->z * -1
                );
                break;
            case '3D':
                $point = array(
                    'x' => $this->x,
                    'y' => $this->z * -1,
                    'z' => $this->y
                );
                break;
        }

        return $point;

    }

    public function asArray()
    {
        return array('coord' => array('x' => $this->x
                    ,'y' => $this->y
                    ,'z' => $this->z));

    }
}