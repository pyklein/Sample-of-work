<?php


/**
 * Suppression d'une remarque d'un dossier
 *
 * @author Jihad
 */
class supprimerRemarque_mrisAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }

    $objRemarque = Remarque_mrisTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objRemarque){
      $this->redirect('@non_autorise');
    }
    
    if($objRemarque->getDossierPostdocId()!=NULL)
    {
      $this->strContenant = 'dossier_postdoc';
      $this->idContenant = $objRemarque->getDossierPostdocId();
    }
    else if($objRemarque->getDossierTheseId()!=NULL)
    {
      $this->strContenant = 'dossier_these';
      $this->idContenant = $objRemarque->getDossierTheseId();
    }
    else if($objRemarque->getDossierEreId()!=NULL)
    {
      $this->strContenant = 'dossier_ere';
      $this->idContenant = $objRemarque->getDossierEreId();
    }
    else
    {
      $this->redirect('@non_autorise');
    }
    $this->objRemarque = $objRemarque;
    $this->objDossier = Doctrine_Core::getTable(ucfirst($this->strContenant))->findOneById($objRequeteWeb->getParameter('dossier_id'));

   
    if ($objRequeteWeb->isMethod('post')){
      $objRemarque->delete();
      $this->getUser()->setFlash('succes', libelle("msg_remarque_suppression_reussie"));
      $this->redirect('dossier_mris/listerRemarque_mris?'.$this->strContenant.'='.$this->idContenant);
    }
  }

}

?>
