<?php

/**
 * Action pour le téléchargement des fichiers joints des dossiers MRIS
 *
 * @author Alexandre WETTA
 */
class telechargerFichierDossierMrisAction extends gridAction {

  public function preExecute() {
    $this->getLogger()->debug("{" . __CLASS__ . "} [" . __FUNCTION__ . "] / DEBUT; ");
    //on vérifie qu'il y a bien tous les paramètres
    if ($this->getRequest()->hasParameter('id') &&
            $this->getRequest()->hasParameter('type_dossier') &&
            $this->getRequest()->hasParameter('type_fichier')) {

      $this->objDossier = Doctrine_Core::getTable($this->getRequest()->getParameter('type_dossier'))->findOneById($this->getRequest()->getParameter('id'));

      if ($this->getRequest()->getParameter('type_dossier') == "Dossier_these") {
        $this->repertoireDossier = "getRepertoireDossiersThese";
      } else if ($this->getRequest()->getParameter('type_dossier') == "Dossier_postdoc") {
        $this->repertoireDossier = "getRepertoireDossiersPostdoc";
      } else if ($this->getRequest()->getParameter('type_dossier') == "Dossier_ere") {
        $this->repertoireDossier = "getRepertoireDossiersEre";
      }
      
    } else {
      $this->getUser()->setFlash('erreur', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('referentiel/index');
    }
    $this->getLogger()->debug("{" . __CLASS__ . "} [" . __FUNCTION__ . "] / FIN; ");
  }

  public function execute($request) {
    $this->getLogger()->debug("{" . __CLASS__ . "} [" . __FUNCTION__ . "] / DEBUT; ");
    $repertoireDossier = $this->repertoireDossier;
    $objUtilTelecharger = new UtilTelecharger();
    $objUtilArbo = new ServiceArborescence();
    //on télécharge le fichier en fonction de son type
    if ($request->getParameter('type_fichier') == "editable") {
      $objUtilTelecharger->telechargerFichier($objUtilArbo->$repertoireDossier() . $this->objDossier->getFichierEditable(), $this->objDossier->getFichierEditableOrig(), true);
    } else if ($request->getParameter('type_fichier') == "pdf") {
      $objUtilTelecharger->telechargerFichier($objUtilArbo->$repertoireDossier() . $this->objDossier->getFichierPdf(), $this->objDossier->getFichierPdfOrig(), true);
    }
    $this->getLogger()->debug("{" . __CLASS__ . "} [" . __FUNCTION__ . "] / FIN; ");
  }

}
?>
