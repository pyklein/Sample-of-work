<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cloreEvenement_mipAction
 *
 * @author William
 */
class cloreEvenement_mipAction extends gridAction{

  public function execute($objRequeteWeb){
    if (!$objRequeteWeb->hasParameter('id')){
     $this->redirect("@non_autorise");
    }
    $objEvenement = Evenement_mipTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objEvenement){
      $this->redirect('@non_autorise');
    }
    

    try{
      $objEvenement->setEstCloture(true);
      $objEvenement->save();
      $this->getUser()->setFlash('success',libelle("msg_evenement_cloture_succes"));
      $this->redirect("dossier_mip/listerEvenement_mips?dossier_mip=".$objEvenement->getDossierMipId());
    } catch (Exception $ex) {
      $this->getUser()->setFlash('error',libelle("msg_evenement_cloture_erreur"));
      $this->redirect("dossier_mip/listerEvenement_mips?dossier_mip=".$objEvenement->getDossierMipId());
    }
  }
}
?>
