<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 23/10/2015
 * Time: 22:53
 */

namespace Itineraire\Renderer\Svg;


use Itineraire\Trajet;
use Topologie\IPoint;

/**
 * Class SvgComputeSize
 * Calcule la taille idéale pour afficher l'ensemble du trajet
 * @package Itineraire\Renderer\Svg
 */
class SvgComputeSize implements ISvgRenderObserver
{
    private $minX;
    private $minZ;

    private $maxX;
    private $maxZ;

    /**
     * @var integer marge autour du tracet
     */
    private $margin;

    /**
     * @param bool $setsize définit si la taille du svg doit être pour correspondre
     * à la taille de la viewBox
     * @param int $margin marge à appliquer au svg
     */
    public function __construct($setsize = false, $margin = 0)
    {
        $this->maxX = 0;
        $this->maxZ = 0;
        $this->minX = 0;
        $this->minZ = 0;

        $this->margin = $margin;
    }

    /**
     * @param SvgRenderer $svgRender
     * @param Trajet $trajet
     */
    public function onPrePointLoop(SvgRenderer $svgRender, Trajet $trajet)
    {
        $this->minX = $trajet->getParcours()[0]->getX();
        $this->minZ = $trajet->getParcours()[0]->getZ();
        $this->maxX = $trajet->getParcours()[0]->getX();
        $this->maxZ = $trajet->getParcours()[0]->getZ();
    }

    public function onPointLoop(SvgRenderer $svgRender, Trajet $trajet, IPoint $point, $precPoint, $index)
    {
        $this->minX = ($this->minX > $point->getX()) ? $point->getX() : $this->minX;
        $this->minZ = ($this->minZ > $point->getZ()) ? $point->getZ() : $this->minZ;

        $this->maxX = ($this->maxX < $point->getX()) ? $point->getX() : $this->maxX;
        $this->maxZ = ($this->maxZ < $point->getZ()) ? $point->getZ() : $this->maxZ;
    }

    public function OnPointLoopFinished(SvgRenderer $svgRender, Trajet $trajet)
    {
        $vbWidth = $this->maxX - $this->minX + $this->margin * 2;
        $vbHeight = $this->maxZ - $this->minZ + $this->margin * 2;

        $svgRender->addAttribut(array('width' => $vbWidth));
        $svgRender->addAttribut(array('height' => $vbHeight));
        $svgRender->addAttribut(array('viewBox' => ''. ($this->minX - $this->margin). ' '
                                                 . ($this->minZ - $this->margin). ' '
                                                 . $vbWidth. ' '
                                                 . $vbHeight));
    }


}