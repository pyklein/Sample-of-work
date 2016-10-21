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
class modifierEvenement_mipAction extends gridAction{
  public function  execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')){
     $this->redirect("@non_autorise");
    }
    $objEvenement = Evenement_mipTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objEvenement){
      $this->redirect('@non_autorise');
    }

    if ($this->getUser()->getUtilisateur()->getId() != $objEvenement->getCreated_by()){
      $this->redirect('@non_autorise');
    }


    $this->strContenant = 'dossier_mip';
    $this->idContenant = $objEvenement->getDossierMipId();

    $this->objForm = new Evenement_mipForm($objEvenement);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('modifier','listerEvenement_mips?dossier_mip='.$this->idContenant);
    }

  }

}
?>
