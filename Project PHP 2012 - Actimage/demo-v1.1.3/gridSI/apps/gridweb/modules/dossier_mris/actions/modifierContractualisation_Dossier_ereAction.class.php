<?php

/**
 * Modification de la contractualisation d'un dossier de thèse
 *
 * @author Alexandre WETTA
 */
class modifierContractualisation_Dossier_ereAction extends gridAction {

  public function preExecute() {
    if ($this->getRequest()->hasParameter('dossier_id')) {
      $this->dossierId = $this->getRequest()->getParameter('dossier_id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerDossier_eres');
    }
  }

  public function execute($request) {
    $this->type_dossier = "Dossier_ere";

    $this->conventionCollective = false;

    //recherche du dossier
    $this->objDossier = Dossier_ereTable::getInstance()->findOneById($this->dossierId);


    if ($this->objDossier) {

      //on cherche s'il y a une convention pour ce dossier
      $objConvention = Convention_dossier_ereTable::getInstance()->findOneByDossierEreId($this->dossierId);

      // s'il existe déjà une convention on utilise celle ci sinon on cherche s'il existe une convention collective
      if ($objConvention) {

        $this->objForm = new Convention_dossier_ereForm($objConvention);
      } else {

        //Recherche d'une convention collective (convention avec un organisme)
        $queryConventionAvecOrganisme = Convention_organismeTable::getInstance()->rechercheConventionCollectiveParDate($this->objDossier->getCreatedAt(), $this->objDossier->getOrganismeId(), $this->type_dossier);

        //si il y a une convention collective on l'utilise sinon on fait une nouvelle convention
        if ($queryConventionAvecOrganisme->count() != 0) {
          $this->conventionCollective = true;
          $objConventionCollective = $queryConventionAvecOrganisme->fetchOne();
          $this->objForm = new Convention_organismeForm($objConventionCollective);
        } else {

          //on fait une nouvelle convention pour le dossier
          $objConvention = new Convention_dossier_ere();
          $objConvention->setDossierEreId($this->dossierId);
          $this->objForm = new Convention_dossier_ereForm($objConvention);
        }
      }

      //post du formulaire
      if ($request->isMethod('post')) {

        //on récupère les fichiers joints
        $this->arrFiles = $request->getFiles('convention_dossier_ere');

        //on lance le form
        $this->processForm('creer', "modifierContractualisation_Dossier_ere?dossier_id=" . $this->dossierId);
      }
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerDossier_eres');
    }
  }

}
?>
