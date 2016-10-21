<?php


/**
 * Suppression d'un evenement d'un dossier
 *
 * @author Jihad
 */
class supprimerEvenement_mrisAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }

    $objEvenement = Evenement_mrisTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objEvenement){
      $this->redirect('@non_autorise');
    }
    
    if($objEvenement->getDossierPostdocId()!=NULL)
    {
      $this->strContenant = 'dossier_postdoc';
      $this->idContenant = $objEvenement->getDossierPostdocId();
    }
    else if($objEvenement->getDossierTheseId()!=NULL)
    {
      $this->strContenant = 'dossier_these';
      $this->idContenant = $objEvenement->getDossierTheseId();
    }
    else if($objEvenement->getDossierEreId()!=NULL)
    {
      $this->strContenant = 'dossier_ere';
      $this->idContenant = $objEvenement->getDossierEreId();
    }
    else
    {
      $this->redirect('@non_autorise');
    }

    $this->objDossier = Doctrine_Core::getTable(ucfirst($this->strContenant))->findOneById($objRequeteWeb->getParameter('dossier_id'));
  
    if ($objRequeteWeb->isMethod('post')){
      $objEvenement->delete();
      $this->getUser()->setFlash('succes', libelle("msg_evenement_suppression_reussie"));
      $this->redirect('dossier_mris/listerEvenement_mris?'.$this->strContenant.'='.$this->idContenant);
    }
  }

}

?>
