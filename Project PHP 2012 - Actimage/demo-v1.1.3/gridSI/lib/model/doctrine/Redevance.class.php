<?php

/**
 * Redevance
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Redevance extends BaseRedevance {

  public function __toString() {
    return $this->getOrganisme()->getIntitule();
  }

  public function afficheRedevanceDetaillee(){
    $str = $this->getOrganisme()->getIntitule(). " - ".$this->getType_redevance()->getIntitule()." (".formatMontantFr($this->getMontant()).")" ;
    return $str ;
  }

}