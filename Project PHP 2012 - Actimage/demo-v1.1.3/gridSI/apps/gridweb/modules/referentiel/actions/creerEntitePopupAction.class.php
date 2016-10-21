<?php

/**
 * Popup pour l'ajout d'une entite
 *
 * @author Alexandre WETTA
 */
class creerEntitePopupAction extends gridAction {

  public function execute($request) {

    $logger = $this->getLogger();

    $logger->debug('DEBUT creerEntitePopupAction');

    $objEntite= new Entite();

    $this->objForm = new EntitePopupForm($objEntite);

    if ($request->isMethod('post')) {

      if ($this->getRequest()->isXmlHttpRequest()) {
        $boolResultat = $this->processForm('creer', null, false, false);
        if ($boolResultat) {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objEntite->getId(), "libelle" => $objEntite->getNomHierarchique());

          $this->getResponse()->setHttpHeader('Content-Type','application/json');
          $logger->debug('FIN creerEntitePopupAction -> version popup');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $this->processForm('creer');
        $logger->debug('FIN creerEntitePopupAction -> sans popup');
      }
    }
  }

}
?>
