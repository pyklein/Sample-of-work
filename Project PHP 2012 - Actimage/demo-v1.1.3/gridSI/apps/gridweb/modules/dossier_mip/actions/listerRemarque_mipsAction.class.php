<?php

/**
 * Description of listerRemarquesAction
 *
 * @author William RICHARDS
 */
class listerRemarque_mipsAction extends gridAction {

  public function execute($objRequeteWeb) {
    //On enregistre l'utilisateur logué
    $this->objUser = $this->getUser();
    //On redirige si on a pas le bon parametre
    if (!$objRequeteWeb->hasParameter('dossier_mip')) {
      $this->redirect('@non_autorise');
    }
    $intIdDossierMip = $objRequeteWeb->getParameter('dossier_mip');
    //redirection si dossier mip inexistant
    if (($this->objDossier = Dossier_mipTable::getInstance()->findOneById($intIdDossierMip))) {

      $this->objFormFiltre = new Remarque_mipFormFilter($intIdDossierMip);
    
      $objRequeteDoctrine = $this->processFiltre('UtilisateurCreatedBy');
 
      $this->arrRemarques = $objRequeteDoctrine->orderBy('created_at DESC')->execute();

      $objRemarque = new Remarque_mip();
      $objRemarque['Dossier_mip'] = Dossier_mipTable::getInstance()->findOneById($intIdDossierMip);
      $this->objForm = new Remarque_mipForm($objRemarque);
      if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter('remarque_mip')) {
        $this->processForm('creer', 'listerRemarque_mips?dossier_mip='.$intIdDossierMip);
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}

?>
