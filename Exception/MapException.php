<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 12/09/2015
 * Time: 16:00
 */

namespace Exception;


class MapException extends \Exception
{
    /**
     * @var string nom de la map demandée
     */
    private $mapRequested;



    public function __construct($map, $message)
    {
        parent::__construct($message);

        if(is_string($map)) { $this->mapRequested = $map;}
        else                { throw new \Exception("La variable map doit être une chaine de caractère");}
    }

    /**
     * @return string nom de la map demandée
     * ayant provoquée une erreur
     */
    public function getMapRequested()
    {
        return $this->mapRequested;
    }
}