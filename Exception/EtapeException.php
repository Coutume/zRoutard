<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 12/09/2015
 * Time: 15:51
 */

namespace Exception;


class EtapeException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}