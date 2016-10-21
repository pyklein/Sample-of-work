<?php


/**
 * Description of listerEvenement_mipsAction
 *
 * @author William RICHARDS
 */
class listerEvenement_mipsAction extends gridAction {

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
     
      $this->objFormFiltre = new Evenement_mipFormFilter($intIdDossierMip);

      $objRequeteDoctrine = $this->processFiltre('UtilisateurCreatedBy');

      $this->processPager($objRequeteDoctrine->orderBy('est_cloture')->addOrderBy('date DESC'), 'Evenement_mip');

      $objEvenement = new Evenement_mip();
      $objEvenement['Dossier_mip'] = Dossier_mipTable::getInstance()->findOneById($intIdDossierMip);
      $this->objForm = new Evenement_mipForm($objEvenement);
      if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter($this->objForm->getName())) {
        $this->processForm('creer', 'listerEvenement_mips?dossier_mip='.$intIdDossierMip);
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}

?>
