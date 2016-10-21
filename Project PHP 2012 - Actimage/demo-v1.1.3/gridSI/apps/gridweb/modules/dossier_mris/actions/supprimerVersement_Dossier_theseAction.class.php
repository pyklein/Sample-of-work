<?php


/**
 * Suppression d'un versement
 *
 * @author Jihad
 */
class supprimerVersement_Dossier_theseAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }

    $objVersement = Versement_dossier_theseTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objVersement){
      $this->redirect('@non_autorise');
    }
    
    if($objVersement->getDossierTheseId()!=NULL)
    {
      $this->strContenant = 'Dossier_these';
      $this->idContenant = $objVersement->getDossierTheseId();

      $this->objDossier = Dossier_theseTable::getInstance()->findOneById($this->idContenant);
    }
    else
    {
      $this->redirect('@non_autorise');
    }
   
    if ($objRequeteWeb->isMethod('post')){
      $objVersement->delete();
      $this->getUser()->setFlash('succes', libelle("msg_versement_suppression_reussie",array($objVersement['date_versement'])));
      $this->redirect('dossier_mris/modifierFinancement_Dossier_these?dossier_id=' . $this->idContenant);
    }
  }

}

?>
