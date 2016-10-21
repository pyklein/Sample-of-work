<?php

/**
 * popup pour la création d'un nouveau Grade
 *
 * @author Alexandre WETTA
 */
class creerGradePopupAction extends gridAction {

  public function execute($request) {
    $logger = $this->getLogger();

    $logger->debug('DEBUT creerGradePopupAction');

    $objGrade = new Grade();

    $this->objForm = new GradePopupForm($objGrade);

    if ($request->isMethod('post')) {

      if ($this->getRequest()->isXmlHttpRequest()) {
        $boolResultat = $this->processForm('creer', null, false, false);
        if ($boolResultat) {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objGrade->getId(), "libelle" => $objGrade->getIntitule(), "groupe" => $objGrade->getOrganisme_mindef()->getAbreviation());

          $this->getResponse()->setHttpHeader('Content-Type', 'application/json');
          $logger->debug('FIN creerGradePopupAction -> version popup');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $this->processForm('creer');
        $logger->debug('FIN creerGradePopupAction -> sans popup');
      }
    }

    $logger->debug('FIN creerGradePopupAction');
  }

}
?>
