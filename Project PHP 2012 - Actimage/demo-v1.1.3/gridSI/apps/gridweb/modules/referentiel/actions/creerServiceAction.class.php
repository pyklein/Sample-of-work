<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of creerServiceAction
 *
 * @author William
 */
class creerServiceAction extends gridAction{
    public function execute($objRequeteWeb){
      $objService = new Service();
      if(!$objRequeteWeb->hasParameter('organisme')){
        $this->redirect('@non_autorise');
      }
      $objOrganisme = OrganismeTable::getInstance()->findOneById($objRequeteWeb->getParameter('organisme'));
      if (!$objOrganisme || !$objOrganisme->getEstActif()){
        $this->redirect('@non_autorise');
      }
      $objService->setOrganisme($objOrganisme);
      $this->idContenant = $objRequeteWeb->getParameter('organisme');
      $this->objForm = new ServiceForm($objService);
      if ($objRequeteWeb->isMethod('post')){
        $this->processForm('creer','listerServices?organisme='.$this->idContenant);
      }
    }
}
?>
