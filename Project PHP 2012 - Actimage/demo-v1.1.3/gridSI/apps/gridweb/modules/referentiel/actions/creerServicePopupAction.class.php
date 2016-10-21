<?php

/**
 * Popup pour la création d'un service
 *
 * @author Alexandre WETTA
 */
class creerServicePopupAction extends gridAction {

  public function execute($request) {
    $logger = $this->getLogger();

    $logger->debug('DEBUT creerServicePopupAction');

    $objService = new Service();

    $this->objForm = new ServicePopupForm($objService);

    if ($request->isMethod('post')) {

      if ($this->getRequest()->isXmlHttpRequest()) {
        $boolResultat = $this->processForm('creer', null, false, false);
        if ($boolResultat) {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objService->getId(), "libelle" => $objService->getIntitule(), "groupe" => $objService->getOrganisme()->getIntitule());

          $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
          $logger->debug('FIN creerServicePopupAction -> version popup');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $this->processForm('creer');
        $logger->debug('FIN creerServicePopupAction -> sans popup');
      }
    }

    $logger->debug('FIN creerServicePopupAction');
  }

}
