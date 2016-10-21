<?php

/**
 * Listage des prix
 *
 * @author Actimage
 */
class listerPrixsAction extends gridAction{
    public function preExecute()
  {
  }


  public function execute($request)
  {

//    $this->arrPrix = PrixTable::getInstance()->retrievePrix();

    $objRequeteDoctrine =  PrixTable::getInstance()->retrievePrix();
    $this->processPager($objRequeteDoctrine, 'Prix');
  }

  /**
   */
  public function postExecute()
  {
  }
  
}
?>
