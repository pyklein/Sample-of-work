<?php

/**
 * Creation d'un nouvel organisme mindef avec un popup
 *
 * @author Alexandre WETTA
 */
class creerOrganisme_mindefPopupAction extends gridAction {

  public function execute($request) {

    $logger = $this->getLogger();
    $logger->debug('DEBUT creerOrganisme_mindefPopupAction');


    $objOrganisme_Mindef = new Organisme_mindef();

    $this->objForm = new Organisme_mindefForm($objOrganisme_Mindef);

    if ($request->isMethod('post')) {
      $logger->debug('creerOrganisme_mindefPopupAction -> post du formulaire');

      if ($this->getRequest()->isXmlHttpRequest()) {
        $logger->debug('creerOrganisme_mindefPopupAction -> post du formulaire en Ajax');
        $boolResultat = $this->processForm('creer', null, false, false);
        
        if ($boolResultat)
        {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objOrganisme_Mindef->getId(), "libelle" => $objOrganisme_Mindef->getAbreviation());

          $this->getResponse()->setHttpHeader('Content-Type','application/json');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $logger->debug('creerOrganisme_mindefPopupAction -> post du formulaire sans Ajax');
        $this->processForm('creer');
      }
    }
    $logger->info('FIN creerOrganisme_mindefPopupAction');
  }

}
?>
