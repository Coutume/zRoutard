<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 22/10/2015
 * Time: 09:33
 */
namespace Topologie;


/**
 * Class Point Représente un point sur la carte. Contient des fonctions pour
 * transformer les coordonnées au format Minecraft (z inversée)
 * @package Topologie
 */
interface IPoint
{
    /**
     * @return int|string
     */
    public function getX();

    /**
     * @return int|string
     */
    public function getY();

    /**
     * @return int|string
     */
    public function getZ();

    /**
     * @return string
     */
    public function getDimension();

    /**
     * @param IPoint $point
     * @return float|int La distance entre cet objet point et $point
     * @throws \Exception Si les 2 points n'ont pas la même dimension (2D ou 3D)
     */
    public function getDistance(IPoint &$point);

    public function get2dDistance(IPoint &$point);

    public function get3dDistance(IPoint &$point);

    /**
     * Renvoie la position au format géométrique standard :
     * - y et z inversée
     * - axe y inversé par rapport à l'axe z de Minecraft
     */
    public function getStandardPos();

    public function asArray();
}