<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 23/10/2015
 * Time: 21:20
 */

namespace Itineraire\Renderer\Svg;

use Itineraire\Trajet;
use Topologie\IPoint;

interface ISvgRenderObserver
{
    public function onPrePointLoop(SvgRenderer $svgRender, Trajet $trajet);

    public function onPointLoop(SvgRenderer $svgRender, Trajet $trajet, IPoint $point, $precPoint, $index);

    public function OnPointLoopFinished(SvgRenderer $svgRender, Trajet $trajet);
}