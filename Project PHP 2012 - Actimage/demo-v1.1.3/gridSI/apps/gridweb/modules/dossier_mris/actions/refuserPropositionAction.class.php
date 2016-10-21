<?php

/**
 * Refuser un dossier mris
 *
 * @author Jihad 
 */
class refuserPropositionAction extends gridAction {

  public function execute($objRequeteWeb) {
  
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

    if ((!$this->objDossier = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant)))
    {
      $this->redirect('@non_autorise');
    }

    $strStatutDossierTable = "Statut_".strtolower($this->strModelContenant)."Table";

    if ($objRequeteWeb->isMethod('post'))
    {
      $this->objDossier['statut_'.strtolower($this->strModelContenant). '_id'] = $strStatutDossierTable::REFUSE ;

      $this->objDossier->save();
      $this->redirect('dossier_mris/validerDossier?'.strtolower($this->strModelContenant).'='.$this->strIdContenant);

    }
  }

}

?>
