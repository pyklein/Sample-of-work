<?php

/**
 * Departement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Departement extends BaseDepartement {

  public function __toString() {
    return $this->getCodeDepartemental() . " - " . $this->getNom();
  }

  public function getLabelFiltre(){
    return $this->getEstActif() ? $this->__toString() : $this->__toString().' (Inactif)';
  }

}