<?php


/**
 * Suppression d'un élément de suivi de dossier de stage postdoctoral
 *
 * @author Jihad
 */
class supprimerSuiviDossier_postdocAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!($objRequeteWeb->hasParameter('id') || $objRequeteWeb->hasParameter('dossier_id'))){
      $this->redirect("@non_autorise");
    }

    $this->objSuivi = Suivi_dossier_postdocTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$this->objSuivi){
      $this->redirect('@non_autorise');
    }
    
    $this->objDossier = Dossier_postdocTable::getInstance()->findOneById($objRequeteWeb->getParameter('dossier_id'));
    $this->strModelContenant = 'Dossier_postdoc';
    $this->idContenant = $this->objSuivi->getDossierPostdocId();
    
    if ($objRequeteWeb->isMethod('post')){
      $this->objSuivi->delete();
      $this->getUser()->setFlash('succes', libelle("msg_suivi_postdoc_suppression_reussie"));
      $this->redirect("dossier_mris/listerSuivi_".$this->strModelContenant."s?".  strtolower($this->strModelContenant)."_id=".$this->idContenant);
    }
  }

}

?>
