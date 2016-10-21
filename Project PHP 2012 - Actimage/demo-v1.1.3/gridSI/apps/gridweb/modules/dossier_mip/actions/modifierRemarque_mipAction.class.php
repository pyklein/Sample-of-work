<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modifierRemarque_mipAction
 *
 * @author William
 */
class modifierRemarque_mipAction extends gridAction{
  public function  execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')){
     $this->redirect("@non_autorise");
    }
    $objRemarque = Remarque_mipTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objRemarque){
      $this->redirect('@non_autorise');
    }
    if ($this->getUser()->getUtilisateur()->getId() != $objRemarque->getCreated_by()){
      $this->redirect('@non_autorise');
    }

    $this->strContenant = 'dossier_mip';
    $this->idContenant = $objRemarque->getDossierMipId();

    $this->objForm = new Remarque_mipForm($objRemarque);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('modifier','listerRemarque_mips?'.$this->strContenant.'='. $this->idContenant);
    }
    
  }

}
?>
