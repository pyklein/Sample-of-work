<?php

/**
 * Réouverture d'un dossier BPI
 *
 * @author Alexandre WETTA
 */
class rouvrirDossier_bpiAction extends gridAction {

  public function execute($request) {

    if ($request->hasParameter('id')) {
      //recherche du dossier BPI
      $objDossier = Dossier_bpiTable::getInstance()->findOneById($request->getParameter('id'));
      $this->objDossier = $objDossier;
    } else {
      $this->redirect("@non_autorise");
    }


    //on vérifie si le dossier est clos ou pas, puis on crée le formulaire
    if ($objDossier->getEstClos()) {
      $this->objForm = new Dossier_bpiCloreRouvrirForm('rouvrir', $objDossier);
      $objDossier->setEstClos(false);
    } else {
      $this->objForm = new Dossier_bpiCloreRouvrirForm('clore', $objDossier);
      $objDossier->setEstClos(true);
    }

    if ($request->isMethod('post')) {
      $this->processForm('modifier');
    }
  }

}
?>
