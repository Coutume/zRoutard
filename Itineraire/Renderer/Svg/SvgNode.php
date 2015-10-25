<?php
/**
 * Created by PhpStorm.
 * User: moribus
 * Date: 24/10/2015
 * Time: 12:22
 */

namespace Itineraire\Renderer\Svg;

/**
 * Class SvgNode
 * Représente une balise (= noeud) SVG, avec ses attributs et ses noeuds enfants
 * ATTENTION : celle classe ne VERIFIE PAS si vos attributs et noeuds sont
 * valides dans la spec SVG
 * @package Itineraire\Renderer\Svg
 */
class SvgNode
{
    /**
     * @var string le nom de la balise
     */
    private $nom;

    private $baliseVide;

    /**
     * @var array contient tous les objets sous forme de chaine de caractères à inclure au svg
     */
    private $noeuds;

    /**
     * @var array liste des attributs de ce svg
     */
    private $attributs;

    /**
     * @var string du texte à afficher dans le noeud. Dans les specs, le texte
     * est lui-même un noeud, mais pour les besoins de l'application inutile de
     * compliquer l'implémentation
     */
    private $texte;

    /**
     * @param string $nom le nom de la balise
     * @param bool $baliseVide définit si cette balise
     * est une balise dites "vide" (= n'a pas d'enfants)
     */
    public function __construct($nom, $baliseVide = false)
    {
        $this->nom = $nom;
        $this->baliseVide = $baliseVide;

        $this->texte = '';
        $this->noeuds = array();
        $this->attributs = array();
    }

    /**
     * Ajoute un noeud (= une balise) à ce SVG
     * @param SvgNode $noeud
     * @param int $zIndex Le niveau de profondeur de l'élément. Permet
     * de dessiner des éléments au dessus des éléments ayant un niveau inférieur
     */
    public function addNoeud($noeud, $zIndex = 0)
    {
        if(!isset($this->noeuds[$zIndex]))
        {
            $this->noeuds[$zIndex] = array();
            ksort($this->noeuds); // tri selon l'index Z par ordre croissant
        }

        $this->noeuds[$zIndex][] = $noeud;
    }

    /**
     * @param array $attribut tableau d'une seule entrée
     * contenant le nom de l'attribut en tant que clé et sa valeur en tant que valeur.
     * Si tableau de plus d'une entrée, les suivantes seront ignorées.
     */
    public function addAttribut($attribut)
    {
        $this->attributs[array_keys($attribut)[0]] = array_values($attribut)[0];
    }

    /**
     * Génère la représentation en chaine de caractères
     * de la balise et de ses noeuds enfants
     * @return string la représentation en chaines de caractères
     * de ce noeud
     */
    public function asString()
    {
        $attr = '';
        $svg = '<';

        foreach($this->attributs as $cle => $attribut)
        {
            $attr = $attr. $cle. '="'. $attribut. '" ';
        }

        $svg = $svg. "{$this->nom} $attr";

        if($this->baliseVide)
        {
            $svg = $svg. '/>';
        }
        else
        {
            $svg = $svg. '>'. $this->texte;

            foreach($this->noeuds as $noeudIndex)
            {
                /**
                 * @var SvgNode[] $noeudIndex tableau des noeuds
                 */
                foreach($noeudIndex as $noeud)
                {
                    $svg = $svg. $noeud->asString();
                }
            }

            $svg = $svg. '</'. $this->nom. '>';
        }

        return $svg;
    }

    /**
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @param string $texte
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
    }
}