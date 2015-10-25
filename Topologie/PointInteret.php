<?php
/**
 * Created by PhpStorm.
 * User: moribus
 * Date: 22/10/2015
 * Time: 08:57
 */

namespace Topologie;


class PointInteret implements IPoint
{

    private $point;
    /**
     * @var string Le nom du point d'intérêt
     */
    private $nom;

    /**
     * @var string Le type du point d'intérêt (ville, aire de service, ...)
     */
    private $type;

    public function __construct(IPoint $point, $nom, $type = 'Lieu')
    {
        if($point != null)
        {
            $this->point = $point;

            if(!is_null($nom))
            {
                $this->nom = $nom;
                $this->type = $type;
            }
            else
            {
                throw new \Exception("Le nom doit être renseigné");
            }
        }
        else
        {
            throw new \Exception("Le point renseigné est null.");
        }
    }

    /**
     * @see PointInteret::$nom
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @see PointInteret::$type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int|string
     */
    public function getX()
    {
        return $this->point->getX();
    }

    /**
     * @return int|string
     */
    public function getY()
    {
        return $this->point->getY();
    }

    /**
     * @return int|string
     */
    public function getZ()
    {
        return $this->point->getZ();
    }

    /**
     * @return string
     */
    public function getDimension()
    {
        return $this->point->getDimension();
    }

    /**
     * @param IPoint $point
     * @return float|int La distance entre cet objet point et $point
     * @throws \Exception Si les 2 points n'ont pas la même dimension (2D ou 3D)
     */
    public function getDistance(IPoint &$point)
    {
        return $this->point->getDistance($point);
    }

    public function get2dDistance(IPoint &$point)
    {
        return $this->point->get2dDistance($point);
    }

    public function get3dDistance(IPoint &$point)
    {
        return $this->point->get3dDistance($point);
    }

    /**
     * Renvoie la position au format géométrique standard :
     * - y et z inversée
     * - axe y inversé par rapport à l'axe z de Minecraft
     */
    public function getStandardPos()
    {
        return $this->point->getStandardPos();
    }

    public function asArray()
    {
        $tab = $this->point->asArray();
        $tab['infos'] = array('nom' => $this->nom,
                              'type' => $this->type);

        return $tab;
    }
}