<?php

/**
 * Liste des organismes MINDEF
 *
 * @author Actimage
 */
class listerOrganisme_mindefsAction extends gridAction
{
  public function preExecute()
  {
  }


  public function execute($request)
  {

//    $this->arrOrganismesMindef = Organisme_mindefTable::getInstance()->retrieveOrganismesMindef();
    

    $objRequeteDoctrine = Organisme_mindefTable::getInstance()->retrieveOrganismesMindef();
//    $objRequeteDoctrine = Doctrine_Core::getTable('Organisme_mindef')->retrieveQuery($objRequeteDoctrine);
    $this->processPager($objRequeteDoctrine, 'Organisme_mindef');
  }

  /**
   */
  public function postExecute()
  {
  }
}
?>
