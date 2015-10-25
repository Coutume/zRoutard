<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 21/10/2015
 * Time: 23:16
 */

namespace PgrImplementation;

/**
 * Class PgDefaultConnexion
 * Gère la connexion à la base
 * Permet de définir une connexion à PostGres en utilisant les infos dans le fichier config.ini
 * @package PgrImplementation
 */
class PgDefaultConnexion extends \PDO
{
    private $host;
    private $port;
    private $database;
    private $user;
    /**
     * Crée une nouvelle connexion PostGres à partir des variables renseignées dans ./config.ini
     */
    public function __construct()
    {
        $config = parse_ini_file('config.ini');
        parent::__construct("pgsql:host={$config['host']}
                            ;port={$config['port']}
                            ;dbname={$config['database']}
                            ;", "{$config['user']}", "{$config['password']}");

        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->database = $config['database'];
        $this->user = $config['user'];
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}