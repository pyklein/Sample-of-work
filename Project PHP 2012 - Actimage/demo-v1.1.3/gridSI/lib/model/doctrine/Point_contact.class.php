<?php

/**
 * Point_contact
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Point_contact extends BasePoint_contact
{
  public function __toString(){
   if ($this->getLaboratoireId() != null){
     return $this->getLaboratoire()->__toString();
   } elseif ($this->getServiceId() != null){
     return $this->getService()->__toString();
   } else {
     return $this->getOrganisme()->__toString();
   }
  }

}