<?php

/**
 * Civilite
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Civilite extends BaseCivilite
{

  /**
   * Surcharge la methode par defaut pour recuperer l'intitule la civilité
   *
   * @return string L'intitule de la civilité
   *
   * @author Simeon PETEV
   */
  public function  __toString()
  {
    return $this->getIntitule();
  }
}