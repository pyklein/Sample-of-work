<?php

/**
 * Renseignement de la date d'envoi pour un avis/suivi d'un dossier après commission
 *
 * @author Jihad
 */
class creerDateAvisCommissionAction extends gridAction {

  public function execute($objRequeteWeb) {

    if($objRequeteWeb->hasParameter('id'))
    {
      $this->strIdCommission = $objRequeteWeb->getParameter('id');
    }
    else
    {
      $this->redirect("@non_autorise");
    }

    $this->objAvis = Avis_mrisTable::getInstance()->findOneById($this->strIdCommission);

    if($this->objAvis->getDossierPostdocId()!=NULL)
    {
      $this->strContenant = 'dossier_postdoc';
      $this->idContenant = $this->objAvis->getDossierPostdocId();
    }
    else if($this->objAvis->getDossierTheseId()!=NULL)
    {
      $this->strContenant = 'dossier_these';
      $this->idContenant = $this->objAvis->getDossierTheseId();
    }
    else if($this->objAvis->getDossierEreId()!=NULL)
    {
      $this->strContenant = 'dossier_ere';
      $this->idContenant = $this->objAvis->getDossierEreId();
    }
    else
    {
      $this->redirect('@non_autorise');
    }

    $this->objForm = new Avis_mris_dateForm($this->objAvis);
    if ($objRequeteWeb->isMethod('post')){
      $this->processForm('creer','suiviCommissionDossier?'.$this->strContenant.'_id='.$this->idContenant.'&commission_id='.$this->strIdCommission);
    }
  }
}

?>
