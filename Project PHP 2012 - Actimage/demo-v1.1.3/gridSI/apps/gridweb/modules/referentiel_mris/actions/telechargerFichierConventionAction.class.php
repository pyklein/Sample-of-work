<?php

/**
 * Action pour le téléchargement des fichiers joints des conventions
 *
 * @author Alexandre WETTA
 */
class telechargerFichierConventionAction extends gridAction {

  public function preExecute() {
    $this->getLogger()->debug("{" . __CLASS__ . "} [" . __FUNCTION__ . "] / DEBUT; ");
    //on vérifie qu'il y a bien tous les paramètres
    if ($this->getRequest()->hasParameter('id') &&
            $this->getRequest()->hasParameter('type_dossier')) {

      if ($this->getRequest()->getParameter('type_dossier') == "Dossier_these") {
        $this->objConvention = Convention_dossier_theseTable::getInstance()->findOneById($this->getRequest()->getParameter('id'));
        $this->repertoireDossier = "getRepertoireConventionDossierThese";
        $this->objDossier = Dossier_theseTable::getInstance()->findOneById($this->objConvention->getDossierTheseId());
      } else if ($this->getRequest()->getParameter('type_dossier') == "Dossier_postdoc") {
        $this->objConvention = Convention_dossier_postdocTable::getInstance()->findOneById($this->getRequest()->getParameter('id'));
        $this->repertoireDossier = "getRepertoireConventionDossierPostdoc";
        $this->objDossier = Dossier_postdocTable::getInstance()->findOneById($this->objConvention->getDossierPostdocId());
      } else if ($this->getRequest()->getParameter('type_dossier') == "Dossier_ere") {
        $this->objConvention = Convention_dossier_ereTable::getInstance()->findOneById($this->getRequest()->getParameter('id'));
        $this->repertoireDossier = "getRepertoireConventionDossierEre";
        $this->objDossier = Dossier_ereTable::getInstance()->findOneById($this->objConvention->getDossierEreId());
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

    //on télécharge le fichier
    $objUtilTelecharger->telechargerFichier($objUtilArbo->$repertoireDossier($this->objDossier->getNumeroAAfficher()) . $this->objConvention->getFichier(), $this->objConvention->getFichierOrig(), true);

    $this->getLogger()->debug("{" . __CLASS__ . "} [" . __FUNCTION__ . "] / FIN; ");
  }
  
}
?>
