<?php

/**
 * Listes des inventeurs
 * @author Gabor JAGER
 */
class listerInventeursAction extends gridAction
{
  public function  preExecute()
  {
    parent::preExecute();
  }
  
  public function execute($objRequete)
  {
    $objRequeteDoctrine = InventeurTable::getInstance()->retrieveInventeursDansOrdre();
    $this->processPager($objRequeteDoctrine, 'Inventeur');
  }

  public function  postExecute()
  {
    parent::postExecute();
  }
}
