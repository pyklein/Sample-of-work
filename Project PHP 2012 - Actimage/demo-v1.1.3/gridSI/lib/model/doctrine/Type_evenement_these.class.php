<?php

/**
 * Type_evenement_these
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Type_evenement_these extends BaseType_evenement_these
{
  public function  __toString()
  {
    return $this->getIntitule();
  }

}