<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 24/10/2015
 * Time: 13:34
 */

namespace Itineraire\Renderer\Svg;


use Itineraire\Trajet;
use Topologie\IPoint;
use Topologie\PointInteret;

class SvgPoiRenderer implements ISvgRenderObserver
{
    public function __construct()
    {

    }

    public function onPrePointLoop(SvgRenderer $svgRender, Trajet $trajet)
    {
        // Rien à faire ici
    }

    public function onPointLoop(SvgRenderer $svgRender, Trajet $trajet, IPoint $point, $precPoint, $index)
    {
        if($point instanceof PointInteret)
        {
            $svgCircle = new SvgNode('circle', true);
            $svgCircle->addAttribut(array('cx' => $point->getX()));
            $svgCircle->addAttribut(array('cy' => $point->getZ()));
            $svgCircle->addAttribut(array('r' => 12));
            $svgCircle->addAttribut(array('stroke' => 'orange'));
            $svgCircle->addAttribut(array('stroke-width' => 2));
            $svgCircle->addAttribut(array('fill' => 'limegreen'));

            $text = new SvgNode('text', false);
            $text->addAttribut(array('x' => ($point->getX() + 15)));
            $text->addAttribut(array('y' => ($point->getZ() + 10)));
            $text->addAttribut(array('style' => 'fill: orange; stroke: orange; stroke-width: 0px; font-size: 30px; font-weight: bold;'));
            $text->setTexte($point->getNom());

            $svgRender->addNoeud($text, 3);
            $svgRender->addNoeud($svgCircle, 2);
        }
    }

    public function OnPointLoopFinished(SvgRenderer $svgRender, Trajet $trajet)
    {
        // Rien à faire ici
    }
}