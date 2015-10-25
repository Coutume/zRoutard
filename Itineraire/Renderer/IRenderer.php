<?php
/**
 * Created by PhpStorm.
 * User: flori
 * Date: 23/10/2015
 * Time: 16:50
 */

namespace Itineraire\Renderer;


use Itineraire\Trajet;

/**
 * Interface IRenderer
 * Définit la méthode à implémenter pour transformer un itinéraire
 * en un document comme du svg, une image, du JSON, ...
 * @package Itineraire\Renderer
 */
interface IRenderer
{
    /**
     * Transforme un trajet en un document.
     * @param Trajet $trajet le trajet à transformer
     * @return mixed
     */
    public function render(Trajet $trajet);
}