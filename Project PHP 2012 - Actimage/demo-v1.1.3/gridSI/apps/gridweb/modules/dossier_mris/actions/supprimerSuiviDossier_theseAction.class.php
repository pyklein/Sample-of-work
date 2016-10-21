<?php


/**
 * Suppression d'un élément de suivi de dossier de these
 *
 * @author Jihad
 */
class supprimerSuiviDossier_theseAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!($objRequeteWeb->hasParameter('id') || $objRequeteWeb->hasParameter('dossier_id'))){
      $this->redirect("@non_autorise");
    }

    $this->objSuivi = Suivi_dossier_theseTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$this->objSuivi){
      $this->redirect('@non_autorise');
    }

    $this->objDossier = Dossier_theseTable::getInstance()->findOneById($objRequeteWeb->getParameter('dossier_id'));
    $this->strModelContenant = 'Dossier_these';
    $this->idContenant = $this->objSuivi->getDossierTheseId();
    
    if ($objRequeteWeb->isMethod('post')){
      $this->objSuivi->delete();
      $this->getUser()->setFlash('succes', libelle("msg_suivi_these_suppression_reussie"));
      $this->redirect("dossier_mris/listerSuivi_".$this->strModelContenant."s?".  strtolower($this->strModelContenant)."_id=".$this->idContenant);
    }
  }

}

?>
