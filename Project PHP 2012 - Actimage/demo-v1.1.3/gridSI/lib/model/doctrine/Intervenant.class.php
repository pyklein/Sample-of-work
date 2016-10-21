<?php

/**
 * Intervenant
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Intervenant extends BaseIntervenant
{

  /**
   * Permet de convertir un objet au string
   * @return string
   */
  public function __toString()
  {
    return $this->getPrenom()." ".$this->getNom();
  }


  /**
   * Recupere le nom de l'organisme sans se soucier s'il existe ou pas
   *
   * @return String Le nom de l'organisme s'il existe, chaine vide sinon
   *
   * @author Simeon PETEV
   */
  public function getNomOrganisme()
  {
    return ($this->getOrganisme()->getId()) ? $this->getOrganisme()->getIntitule() : "";
  }

  public function addEncadrantTheseSansSave($objEncadrantThese)
  {
    $this->getEncadrantThese()->add($objEncadrantThese);
  }

  public function removeEncadrantTheseSansSave($objEncadrantThese)
  {
    $this->getEncadrantThese()->remove($objEncadrantThese);
  }

  /**
   * retourne l'encadrant sous une forme abrégée ex: M Bernard DUPONT
   * @return string
   * @author Alexandre WETTA
   */
  public function afficheEncadrantAbrLettre(){
    return $this->getCivilite()->getAbreviation()." ".$this->getPrenom()." ".$this->getNom();
  }

  /**
   * retourne l'encadrant sous une forme complete ex: Monsieur Bernard DUPONT
   * @return string
   * @author Alexandre WETTA
   */
  public function afficheEncadrantCompletLettre(){
    return $this->getCivilite()->getIntitule()." ".$this->getPrenom()." ".$this->getNom();
  }


  public function getNomLaboratoire(){
    return $this->getLaboratoire()->getIntitule();
  }

  
}