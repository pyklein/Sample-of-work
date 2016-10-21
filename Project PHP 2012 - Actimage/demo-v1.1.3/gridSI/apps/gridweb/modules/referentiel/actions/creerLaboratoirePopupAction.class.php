<?php

/**
 * Popup pour la création d'un laboratoire
 *
 * @author Alexandre WETTA
 */
class creerLaboratoirePopupAction extends gridAction {

  public function execute($request) {

    $logger = $this->getLogger();

    $logger->debug('DEBUT creerLaboratoirePopupAction');

    $objLaboratoire = new Laboratoire();
    $this->objForm = new LaboratoirePopupForm($objLaboratoire);

    if ($request->isMethod('post')) {

      if ($this->getRequest()->isXmlHttpRequest()) {
        $boolResultat = $this->processForm('creer', null, false, false);
        if ($boolResultat) {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objLaboratoire->getId(), "libelle" => $objLaboratoire->getIntitule());

          $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
          $logger->debug('FIN creerLaboratoirePopupAction -> version popup');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $this->processForm('creer');
        $logger->debug('FIN creerLaboratoirePopupAction -> sans popup');
      }
    }

    $logger->debug('FIN creerLaboratoirePopupAction');
  }

}
?>
