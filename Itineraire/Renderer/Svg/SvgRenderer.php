<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 23/10/2015
 * Time: 16:54
 */

namespace Itineraire\Renderer\Svg;


use Itineraire\Renderer\IRenderer;
use Itineraire\Trajet;
use Topologie\IPoint;

/**
 * Class SvgRenderer
 * Permet de dessiner le trajet dans une image SVG
 * ATTENTION : cette classe ne dessine rien, vous devez lui définir des ISvgRenderer
 * afin de dessiner le trajet
 * @package Itineraire\Renderer
 */
class SvgRenderer extends SvgNode implements IRenderer
{
    /**
     * @var ISvgRenderObserver[] les observeurs à invoquer lorsqu'un évènement de rendu
     * se produit.
     */
    private $svgRenderer;

    public function __construct($zMaxIndex = 10)
    {
        parent::__construct("svg");

        $this->addAttribut(array('xmlns' => 'http://www.w3.org/2000/svg'));
        $this->addAttribut(array('version' => "1.1"));
        $this->addAttribut(array('xmlns:xlink' => "http://www.w3.org/1999/xlink"));

        $this->svgRenderer = array();
    }

    /**
     * Transforme un trajet en un document.
     * @param Trajet $trajet le trajet à transformer
     * @return mixed
     */
    public function render(Trajet $trajet)
    {
        $points = $trajet->getParcours();

        $this->firePrePointLoop($trajet);
        $pointPrec = null;
        for($i = 0; $i < count($points); $i++)
        {
            $this->firePointLoop($trajet, $points[$i], $pointPrec, $i);

            $pointPrec = $points[$i];
        }

        $this->firePointLoopFinished($trajet);

        $svg = $this->asString();

        return $svg;
    }

    public function asString()
    {
        $svg =  '<?xml version="1.0" encoding="utf-8"?>';

        $svg = $svg. parent::asString();

        return $svg;
    }

    /**
     * Crée un document SVG avec une représentation simple
     * de l'itinéraire
     * @param Trajet $trajet
     * @return mixed
     */
    public static function asSVG(Trajet $trajet)
    {
        $svgrendu = new SvgRenderer();

        $pathRender = new SvgPathPoint(5, 'red');
        $pathRender->getPath()->addAttribut(array('id' => 'route'));
        $svgSizeRender = new SvgComputeSize(true, 100);
        $PoiRender = new SvgPoiRenderer();

        $svgrendu->attach($pathRender);
        $svgrendu->attach($svgSizeRender);
        $svgrendu->attach($PoiRender);

        return $svgrendu->render($trajet);
    }

    /**
     * Ajoute un nouveau rendu à ce svg
     * @param ISvgRenderObserver $observer
     */
    public function attach(ISvgRenderObserver $observer)
    {
        if($observer != null)
        {
            $this->svgRenderer[] = $observer;
        }
    }

    private function firePrePointLoop(Trajet $trajet)
    {
        foreach($this->svgRenderer as $observer)
        {
            $observer->onPrePointLoop($this, $trajet);
        }
    }

    private function firePointLoop(Trajet $trajet, IPoint $point, $precPoint, $index)
    {
        foreach($this->svgRenderer as $observer)
        {
            $observer->onPointLoop($this, $trajet, $point, $precPoint, $index);
        }
    }

    private function firePointLoopFinished(Trajet $trajet)
    {
        foreach($this->svgRenderer as $observer)
        {
            $observer->onPointLoopFinished($this, $trajet);
        }
    }


}