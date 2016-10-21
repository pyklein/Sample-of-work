<?php


/**
 * Suppression d'un versement
 *
 * @author Jihad
 */
class supprimerVersement_Dossier_ereAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }

    $objVersement = Versement_dossier_ereTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objVersement){
      $this->redirect('@non_autorise');
    }
    
    if($objVersement->getDossierEreId()!=NULL)
    {
      $this->strContenant = 'Dossier_ere';
      $this->idContenant = $objVersement->getDossierEreId();

      $this->objDossier = Dossier_ereTable::getInstance()->findOneById($this->idContenant);

    }
    else
    {
      $this->redirect('@non_autorise');
    }
   
    if ($objRequeteWeb->isMethod('post')){
      $objVersement->delete();
      $this->getUser()->setFlash('succes', libelle("msg_versement_suppression_reussie",array($objVersement['date_versement'])));
      $this->redirect('dossier_mris/modifierFinancement_Dossier_ere?dossier_id=' . $this->idContenant);
    }
  }

}

?>
