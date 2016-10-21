<?php
/**
 * Description of modifierCommissionAction
 *
 * @author William
 */
class modifierCommissionAction extends gridAction{

  public function execute($objRequeteWeb){
    if (!$objRequeteWeb->hasParameter('id')){
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerCommissions');
    }
    $this->strId = $objRequeteWeb->getParameter('id');
    $objCommission = CommissionTable::getInstance()->findOneById($this->strId);
    if (!$objCommission){
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerCommissions');
    }

    $this->objForm = new CommissionForm($objCommission);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('modifier',null,false);
    }
  }
}
?>
