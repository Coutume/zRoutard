<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 04/10/2015
 * Time: 15:21
 */

namespace Exception;

use Itineraire\IEtape;


class BadEtapeException extends \Exception
{
    private $depart;
    private $arrivee;
    public function __construct($message, IEtape $depart, IEtape $arrivee)
    {
        parent::__construct($message);

        $this->depart = $depart;
        $this->arrivee = $arrivee;
    }
}