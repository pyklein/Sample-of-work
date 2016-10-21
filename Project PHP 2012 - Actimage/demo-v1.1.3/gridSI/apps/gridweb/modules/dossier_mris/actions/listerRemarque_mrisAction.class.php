<?php

/**
 * Lister les remarques sur les dossiers mris
 *
 * @author Jihad
 */
class listerRemarque_mrisAction extends gridAction {

  public function execute($objRequeteWeb) {
    //On enregistre l'utilisateur logué
    $this->objUser = $this->getUser();
    //On redirige si on a pas le bon parametre
    if ($objRequeteWeb->hasParameter('dossier_these')) {
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_these');
      $this->strModelContenant = 'Dossier_these';
    } elseif ($objRequeteWeb->hasParameter('dossier_ere')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_ere');
      $this->strModelContenant = 'Dossier_ere';
    } elseif ($objRequeteWeb->hasParameter('dossier_postdoc')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_postdoc');
      $this->strModelContenant = 'Dossier_postdoc';
    } else {
      $this->redirect("@non_autorise");
    }

    if (($this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant))) {

      $this->objFormFiltre = new Remarque_mrisFormFilter($this->strIdContenant , $this->strModelContenant);

      $objRequeteDoctrine = $this->processFiltre('UtilisateurCreatedBy');

      $this->processPager($objRequeteDoctrine->orderBy('created_at DESC'),'Remarque_mris');

      $objRemarque = new Remarque_mris();
      $objRemarque[$this->strModelContenant] = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
      $this->objForm = new Remarque_mrisForm($objRemarque);
      if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter('remarque_mris')) {
        $this->processForm('creer', 'listerRemarque_mris?'.strtolower($this->strModelContenant).'='.$this->strIdContenant);
      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}

?>
