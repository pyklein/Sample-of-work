<?php


/**
 * Suppression d'un versement
 *
 * @author Jihad
 */
class supprimerVersement_Dossier_postdocAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }

    $objVersement = Versement_dossier_postdocTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objVersement){
      $this->redirect('@non_autorise');
    }
    
    if($objVersement->getDossierPostdocId()!=NULL)
    {
      $this->strContenant = 'Dossier_postdoc';
      $this->idContenant = $objVersement->getDossierPostdocId();

      $this->objDossier = Dossier_postdocTable::getInstance()->findOneById($this->idContenant);
    }
    else
    {
      $this->redirect('@non_autorise');
    }
   
    if ($objRequeteWeb->isMethod('post')){
      $objVersement->delete();
      $this->getUser()->setFlash('succes', libelle("msg_versement_suppression_reussie",array($objVersement['date_versement'])));
      $this->redirect('dossier_mris/modifierFinancement_Dossier_postdoc?dossier_id=' . $this->idContenant);
    }
  }

}

?>
