<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 22/10/2015
 * Time: 14:43
 */

namespace Topologie;


class PointFactory
{
    /**
     * @param array $point
     * @return IPoint le point crée
     * @throws \Exception
     */
    public static function creerPoint(array $point)
    {
        if(array_key_exists('x', $point) && array_key_exists('z', $point))
        {
            $pointObj = new Point($point['x'], $point['z']);

            if(isset($point['etape']) && isset($point['type']))
            {
                $pointObj = new PointInteret($pointObj, $point['etape'], $point['type']);
            }

            return $pointObj;
        }
        throw new \Exception("Coordonnées introuvable dans le tableau.");
    }
}