<?php

/**
 * Statut
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Statut extends BaseStatut
{
  /**
   * Surcharge la methode par defaut pour retourner l'intitulé
   *
   * @return string L'intitule du statut
   *
   * @author Simeon PETEV
   */
  public function  __toString()
  {
     return $this->getIntitule() ? $this->getIntitule():"";
  }
}