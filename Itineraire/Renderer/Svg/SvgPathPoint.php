<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 23/10/2015
 * Time: 22:05
 */

namespace Itineraire\Renderer\Svg;


use Itineraire\Trajet;
use Topologie\IPoint;

class SvgPathPoint implements ISvgRenderObserver
{
    /**
     * @var SvgNode la balise path
     */
    private $path;
    /**
     * @var string instructions de dessin des lignes
     */
    private $pathLine;

    /**
     * Construit un nouvel objet path avec les options de style associées
     * Dessine une ligne entre chaque point. Convient SEULEMENT pour dessiner
     * un ensemble de points définissant une seule ligne.
     * @param int $taille
     * @param string $couleur
     * @param string $lineCap
     */
    public function __construct($taille = 1, $couleur = 'black', $lineCap = 'round')
    {
        if(is_numeric($taille))
        {
            $this->path = new SvgNode("path", true);
            $this->path->addAttribut(array('stroke-width' => $taille));
            $this->path->addAttribut(array('stroke' => $couleur));
            $this->path->addAttribut(array('stroke-linecap' => $lineCap));
        }
    }

    public function onPrePointLoop(SvgRenderer $svgRender, Trajet $trajet)
    {
        // Rien à faire ici
    }

    /**
     * Ajoute l'instruction de dessin de la ligne ayant pour point de départ $precPpoint
     * et pour point d'arrivée $point au path
     * @param SvgRenderer $svgRender
     * @param Trajet $trajet
     * @param IPoint $point
     * @param IPoint $pointPrec
     * @param $index
     */
    public function onPointLoop(SvgRenderer $svgRender, Trajet $trajet, IPoint $point, $pointPrec, $index)
    {
        if($pointPrec !== null)
        {
            $this->pathLine = $this->pathLine . 'M' . $pointPrec->getX()  . ',' . $pointPrec->getZ() . ' '
                . 'L' . $point->getX() . ',' . $point->getZ() . ' ';
        }
    }

    public function OnPointLoopFinished(SvgRenderer $svgRender, Trajet $trajet)
    {
        $this->path->addAttribut(array("d" => $this->pathLine));
        $svgRender->addNoeud($this->getPath());
    }

    public function getPath()
    {
        return $this->path;
    }
}