<?php

/**
 * Ajout d'une ville en format popup
 *
 * @author Alexandre WETTA
 */
class creerVillePopupAction extends gridAction{
    public function  execute($request) {

      $logger = $this->getLogger();

    $logger->debug('DEBUT creerVillePopupAction');

    $objVille= new Ville();

    $this->objForm = new VilleForm($objVille);

    if ($request->isMethod('post')) {

      if ($this->getRequest()->isXmlHttpRequest()) {
        $boolResultat = $this->processForm('creer', null, false, false);
        if ($boolResultat) {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objVille->getId(), "libelle" => $objVille->getNom());

          $this->getResponse()->setHttpHeader('Content-Type','application/json');
          $logger->debug('FIN creerVillePopupAction -> version popup');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $this->processForm('creer');
        $logger->debug('FIN creerVillePopupAction -> sans popup');
      }
    }

     $logger->debug('FIN creerVillePopupAction');

  }
}
?>
